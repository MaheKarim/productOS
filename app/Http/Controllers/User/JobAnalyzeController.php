<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ResumeAnalysis;
use App\Models\Job;
use App\Services\Interview\InterviewQuestionGeneratorService;
use App\Services\Resume\ResumeAnalyzerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class JobAnalyzeController extends Controller
{
    protected InterviewQuestionGeneratorService $questionGenerator;
    protected ResumeAnalyzerService $analyzerService;

    public function __construct(
        InterviewQuestionGeneratorService $questionGenerator,
        ResumeAnalyzerService $analyzerService
    ) {
        $this->questionGenerator = $questionGenerator;
        $this->analyzerService = $analyzerService;
    }

    /**
     * Display the job analyze dashboard with all analyzed jobs.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // Check if a specific job is being passed for analysis
        $selectedJob = null;
        if ($request->filled('job_id')) {
            $selectedJob = Job::with('category')->find($request->input('job_id'));
        }

        // Get all job analyses for this user
        $query = ResumeAnalysis::with(['job'])
            ->where('user_id', $user->id)
            ->where('analysis_type', 'job_comparison')
            ->whereNotNull('job_id')
            ->latest();

        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('job', function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('company', 'like', "%{$search}%");
            });
        }

        // Apply score filter
        if ($request->filled('match_score')) {
            $scoreRange = $request->input('match_score');
            switch ($scoreRange) {
                case '80-100':
                    $query->where('match_score', '>=', 80);
                    break;
                case '60-79':
                    $query->whereBetween('match_score', [60, 79]);
                    break;
                case '40-59':
                    $query->whereBetween('match_score', [40, 59]);
                    break;
                case '0-39':
                    $query->where('match_score', '<', 40);
                    break;
            }
        }

        // Apply date filter
        if ($request->filled('date_range')) {
            $dateRange = $request->input('date_range');
            $query->where('created_at', '>=', now()->subDays((int) $dateRange));
        }

        $analyses = $query->paginate(10);

        // Calculate statistics
        $totalAnalyses = $query->count();
        $avgScore = round($query->avg('match_score') ?? 0, 1);
        $highMatchCount = $query->where('match_score', '>=', 80)->count();

        return view('user.job-analyze.index', compact('analyses', 'totalAnalyses', 'avgScore', 'highMatchCount', 'selectedJob'));
    }

    /**
     * Display the job analyze dashboard with a specific job selected by slug.
     */
    public function indexWithJob(Request $request, string $slug)
    {
        $user = Auth::user();

        // Find the job by slug
        $selectedJob = Job::with('category')->where('slug', $slug)->first();

        // Get all job analyses for this user
        $query = ResumeAnalysis::with(['job'])
            ->where('user_id', $user->id)
            ->where('analysis_type', 'job_comparison')
            ->whereNotNull('job_id')
            ->latest();

        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('job', function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('company', 'like', "%{$search}%");
            });
        }

        // Apply score filter
        if ($request->filled('match_score')) {
            $scoreRange = $request->input('match_score');
            switch ($scoreRange) {
                case '80-100':
                    $query->where('match_score', '>=', 80);
                    break;
                case '60-79':
                    $query->whereBetween('match_score', [60, 79]);
                    break;
                case '40-59':
                    $query->whereBetween('match_score', [40, 59]);
                    break;
                case '0-39':
                    $query->where('match_score', '<', 40);
                    break;
            }
        }

        // Apply date filter
        if ($request->filled('date_range')) {
            $dateRange = $request->input('date_range');
            $query->where('created_at', '>=', now()->subDays((int) $dateRange));
        }

        $analyses = $query->paginate(10);

        // Calculate statistics
        $totalAnalyses = $query->count();
        $avgScore = round($query->avg('match_score') ?? 0, 1);
        $highMatchCount = $query->where('match_score', '>=', 80)->count();

        return view('user.job-analyze.index', compact('analyses', 'totalAnalyses', 'avgScore', 'highMatchCount', 'selectedJob'));
    }

    /**
     * Show detailed analysis results for a specific job.
     */
    public function show(ResumeAnalysis $analysis)
    {
        $this->authorize('view', $analysis);

        // Get the associated job and resume
        $job = $analysis->job;
        $resume = $analysis->resume;

        // Ensure analysis_data is properly decoded
        if (is_string($analysis->analysis_data)) {
            $analysis->analysis_data = json_decode($analysis->analysis_data, true) ?? [];
        }

        return view('user.job-analyze.show', compact('analysis', 'job', 'resume'));
    }

    /**
     * Prepare interview questions based on analysis weaknesses.
     */
    public function prepareInterview(ResumeAnalysis $analysis, Request $request)
    {
        $this->authorize('view', $analysis);

        try {
            // Ensure analysis_data is properly decoded
            if (is_string($analysis->analysis_data)) {
                $analysis->analysis_data = json_decode($analysis->analysis_data, true) ?? [];
            }

            $job = $analysis->job;

            // Extract weaknesses from the analysis data
            $weaknesses = [];

            // Get weaknesses from analysis data
            if (isset($analysis->analysis_data['weaknesses'])) {
                foreach ($analysis->analysis_data['weaknesses'] as $weakness) {
                    $weaknesses[] = [
                        'type' => 'weakness',
                        'item' => is_array($weakness) ? ($weakness['area'] ?? $weakness) : $weakness,
                        'importance' => 'high',
                        'suggestion' => is_array($weakness) ? ($weakness['suggestion'] ?? '') : ''
                    ];
                }
            }

            // Get gaps as weaknesses if no specific weaknesses found
            if (empty($weaknesses) && isset($analysis->analysis_data['gaps'])) {
                foreach ($analysis->analysis_data['gaps'] as $gap) {
                    $weaknesses[] = [
                        'type' => 'gap',
                        'item' => is_array($gap) ? ($gap['skill'] ?? $gap) : $gap,
                        'importance' => 'medium',
                        'suggestion' => is_array($gap) ? ($gap['importance'] ?? '') : ''
                    ];
                }
            }

            // If still no weaknesses, create some based on the job
            if (empty($weaknesses)) {
                $weaknesses[] = [
                    'type' => 'general',
                    'item' => 'Job-specific experience',
                    'importance' => 'medium',
                    'suggestion' => 'Focus on transferable skills and relevant experience'
                ];
            }

            // Generate interview questions based on weaknesses
            $questions = $this->questionGenerator->generateQuestionsFromWeaknesses(
                $weaknesses,
                $job->job_title ?? 'Position',
                $job->job_details ?? ''
            );

            // Add metadata
            $questions['generated_at'] = now()->format('F j, Y g:i A');
            $questions['job_title'] = $job->job_title ?? 'Position';
            $questions['company'] = $job->company_name ?? 'Company';

            return view('user.job-analyze.prepare-interview', compact('analysis', 'questions'));

        } catch (\Exception $e) {
            Log::error('Failed to generate interview questions: ' . $e->getMessage());

            // Return a fallback set of questions
            $questions = [
                'questions' => [
                    [
                        'question' => 'Tell me about yourself and your background.',
                        'category' => 'general',
                        'ideal_answer' => 'Provide a concise summary of your professional background, highlighting relevant experience and skills for this role.'
                    ],
                    [
                        'question' => 'Why are you interested in this position?',
                        'category' => 'motivation',
                        'ideal_answer' => 'Show enthusiasm for the role and company, connecting your skills to the job requirements.'
                    ],
                    [
                        'question' => 'What are your greatest strengths?',
                        'category' => 'strengths',
                        'ideal_answer' => 'Highlight 2-3 key strengths that are most relevant to the position, with specific examples.'
                    ]
                ],
                'generated_at' => now()->format('F j, Y g:i A'),
                'job_title' => $job->title ?? 'Position',
                'company' => $job->company ?? 'Company'
            ];

            return view('user.job-analyze.prepare-interview', compact('analysis', 'questions'))
                ->with('warning', 'Using fallback questions due to generation error. Please try again later.');
        }
    }

    /**
     * Delete a job analysis.
     */
    public function destroy(ResumeAnalysis $analysis)
    {
        $this->authorize('delete', $analysis);

        $analysis->delete();

        return redirect()->route('user.job-analyze.index')
            ->with('success', 'Analysis deleted successfully.');
    }

    /**
     * Search for jobs to analyze.
     */
    public function searchJobs(Request $request)
    {
        $query = $request->input('q', '');

        $jobs = Job::active()
            ->notExpired()
            ->where(function ($q) use ($query) {
                $q->where('job_title', 'like', "%{$query}%")
                    ->orWhere('company_name', 'like', "%{$query}%");
            })
            ->limit(10)
            ->get(['id', 'job_title', 'company_name', 'location', 'job_type']);

        return response()->json([
            'jobs' => $jobs->map(function ($job) {
                return [
                    'id' => $job->id,
                    'title' => $job->job_title,
                    'company' => $job->company_name,
                    'location' => $job->location ?? 'Remote',
                    'type' => $job->job_type,
                    'url' => route('jobs.show', $job->slug),
                    'analyze_url' => route('resume-builder.job-analysis', ['job_id' => $job->id])
                ];
            })
        ]);
    }

    /**
     * Quick analyze a job from the dashboard.
     */
    public function analyzeJob(Request $request)
    {
        $request->validate([
            'job_id' => 'required|exists:job_listings,id',
        ]);

        $job = Job::findOrFail($request->job_id);

        return redirect()->route('resume-builder.job-analysis', ['job_id' => $job->id]);
    }

    /**
     * Perform inline analysis of a job against user's resume.
     */
    public function performAnalysis(Request $request)
    {
        $request->validate([
            'job_id' => 'required|exists:job_listings,id',
        ]);

        $user = Auth::user();
        $job = Job::findOrFail($request->job_id);

        // Try to get resume text from multiple sources
        $resumeText = null;

        // 1. First check user's resume_data (from Resume Builder upload)
        if (!empty($user->resume_data['raw_text'])) {
            $resumeText = $user->resume_data['raw_text'];
        }

        // 2. If not found, check the latest resume analysis (from Resume Analyzer)
        if (empty($resumeText)) {
            $latestAnalysis = ResumeAnalysis::where('user_id', $user->id)
                ->whereNotNull('raw_resume_text')
                ->where('raw_resume_text', '!=', '')
                ->latest()
                ->first();

            if ($latestAnalysis) {
                $resumeText = $latestAnalysis->raw_resume_text;
            }
        }

        // 3. If still no resume text, ask user to upload
        if (empty($resumeText)) {
            return response()->json([
                'success' => false,
                'message' => 'Please upload your resume first in the Resume Analyzer to analyze it against job postings.',
                'redirect' => route('resume-builder.index')
            ], 400);
        }

        // Check feature access
        $access = app(\App\Services\FeatureAccessService::class)->checkAccess($user, 'resume_builder');
        if ($access['status'] !== 'allowed') {
            return response()->json([
                'success' => false,
                'message' => $access['message']
            ], 403);
        }

        try {

            // Get job details
            $jobDetails = [
                'title' => $job->job_title,
                'company' => $job->company_name,
                'description' => $job->job_details,
                'skills' => $job->job_data['skills'] ?? [],
                'requirements' => $job->job_data['requirements'] ?? [],
                'experience_level' => $job->experience_level,
            ];

            // Perform job-resume analysis
            $analysis = $this->analyzerService->analyzeAgainstJob($resumeText, $jobDetails);

            // Store analysis results
            $analysisRecord = ResumeAnalysis::create([
                'user_id' => $user->id,
                'job_id' => $job->id,
                'analysis_type' => 'job_comparison',
                'resume_text' => $resumeText,
                'job_description' => json_encode($jobDetails),
                'analysis_results' => $analysis,
                'confidence_score' => $analysis['overall_match_score'] ?? 0,
            ]);

            // Deduct credits
            app(\App\Services\FeatureAccessService::class)->deductCredits($user, 'resume_builder');

            return response()->json([
                'success' => true,
                'message' => 'Analysis completed successfully!',
                'analysis' => $analysis,
                'analysis_id' => $analysisRecord->id,
                'redirect' => route('user.job-analyze.index')
            ]);

        } catch (\Exception $e) {
            Log::error('Job-resume analysis error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while analyzing your resume against this job. Please try again.'
            ], 500);
        }
    }
}