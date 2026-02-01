<?php

namespace App\Http\Controllers;

use App\Services\Resume\ResumeBuilderService;
use App\Services\Resume\ResumeParserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // Added import

class ResumeBuilderController extends Controller
{
    protected ResumeBuilderService $builderService;
    protected ResumeParserService $parserService;

    public function __construct(ResumeBuilderService $builderService, ResumeParserService $parserService)
    {
        $this->builderService = $builderService;
        $this->parserService = $parserService;
    }

    public function index()
    {
        $access = app(\App\Services\FeatureAccessService::class)->checkAccess(Auth::user(), 'resume_builder');
        if ($access['status'] !== 'allowed') {
            return redirect()->route('dashboard')->with('error', $access['message']);
        }
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
}
