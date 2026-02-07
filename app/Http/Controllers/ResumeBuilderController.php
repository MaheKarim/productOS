<?php

namespace App\Http\Controllers;

use App\Services\Resume\ResumeBuilderService;
use App\Services\Resume\ResumeParserService;
use App\Services\Resume\ResumeAnalyzerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ResumeBuilderController extends Controller
{
    protected ResumeBuilderService $builderService;
    protected ResumeParserService $parserService;
    protected ResumeAnalyzerService $analyzerService;

    public function __construct(
        ResumeBuilderService $builderService,
        ResumeParserService $parserService,
        ResumeAnalyzerService $analyzerService
    ) {
        $this->builderService = $builderService;
        $this->parserService = $parserService;
        $this->analyzerService = $analyzerService;
    }

    public function index()
    {
        $user = Auth::user();
        return view('tools.resume-builder.index', compact('user'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'resume' => 'required|file|mimes:pdf,docx|max:5120', // 5MB
        ]);

        try {
            $parsedData = $this->parserService->parse($request->file('resume'));

            // Save to user profile
            $user = Auth::user();
            $user->resume_data = $parsedData;
            $user->save();

            return response()->json(['success' => true, 'message' => 'Resume uploaded and parsed successfully!', 'data' => $parsedData]);

        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function generate(Request $request)
    {
        $request->validate([
            'job_description' => 'required|string|min:50',
        ]);

        try {
            $user = Auth::user();

            // Deduct credits
            $deducted = app(\App\Services\FeatureAccessService::class)->deductCredits($user, 'resume_builder');
            if (!$deducted) {
                return response()->json(['success' => false, 'message' => 'Insufficient credits to generate resume.'], 403);
            }

            $optimizedData = $this->builderService->generateOptimizedResume($user, $request->input('job_description'));

            // Store optimized data in session for download
            session(['optimized_resume' => $optimizedData]);

            return response()->json(['success' => true, 'data' => $optimizedData]);

        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function download(string $format = 'pdf')
    {
        $data = session('optimized_resume');

        if (!$data) {
            return redirect()->route('resume-builder.index')->with('error', 'No optimized resume found. Please generate one first.');
        }

        if ($format === 'pdf') {
            return $this->builderService->exportToPdf($data);
        } elseif ($format === 'docx') {
            $path = $this->builderService->exportToDocx($data);
            return response()->download($path)->deleteFileAfterSend(true);
        }

        abort(400, 'Invalid format');
    }

    /**
     * Analyze resume for ATS compatibility.
     */
    public function analyze(Request $request)
    {
        $request->validate([
            'resume' => 'required|file|mimes:pdf,docx|max:5120',
        ]);

        try {
            $user = Auth::user();

            // Check feature access
            $access = app(\App\Services\FeatureAccessService::class)->checkAccess($user, 'resume_builder');
            if ($access['status'] !== 'allowed') {
                return response()->json(['success' => false, 'message' => $access['message']], 403);
            }

            // Deduct credits
            $deducted = app(\App\Services\FeatureAccessService::class)->deductCredits($user, 'resume_builder');
            if (!$deducted) {
                return response()->json(['success' => false, 'message' => 'Insufficient credits to analyze resume.'], 403);
            }

            // Parse the resume
            $file = $request->file('resume');
            $parsedData = $this->parserService->parse($file);

            // Get raw text for analysis
            $rawText = $parsedData['raw_text'] ?? '';
            if (empty($rawText)) {
                return response()->json(['success' => false, 'message' => 'Could not extract text from resume.'], 400);
            }

            // Analyze with AI
            $result = $this->analyzerService->analyze($rawText, $file->getClientOriginalName());

            return response()->json([
                'success' => true,
                'analysis' => $result['data'],
                'analysis_id' => $result['analysis']->id,
            ]);

        } catch (\Exception $e) {
            Log::error('Resume analysis error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}

