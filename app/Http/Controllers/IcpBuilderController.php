<?php

namespace App\Http\Controllers;

use App\Models\Icp;
use App\Services\IcpGeneratorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class IcpBuilderController extends Controller
{
    protected IcpGeneratorService $generatorService;

    public function __construct(IcpGeneratorService $generatorService)
    {
        $this->generatorService = $generatorService;
    }

    public function index()
    {
        $icps = Icp::where('user_id', Auth::id())->latest()->get();
        return view('tools.icp-builder.index', compact('icps'));
    }

    public function create()
    {
        return view('tools.icp-builder.wizard');
    }

    public function store(Request $request)
    {
        $request->validate([
            'project_name' => 'required|string|max:255',
            'product_description' => 'required|string|min:20',
            // Add other input validations as needed
        ]);

        $inputData = $request->all();

        try {
            // Check credits
            $user = Auth::user();
            $access = app(\App\Services\FeatureAccessService::class)->checkAccess($user, 'icp_builder');
            if ($access['status'] !== 'allowed') {
                return response()->json(['success' => false, 'message' => $access['message']], 403);
            }

            // Deduct credits
            $deducted = app(\App\Services\FeatureAccessService::class)->deductCredits($user, 'icp_builder');
            if (!$deducted) {
                return response()->json(['success' => false, 'message' => 'Insufficient credits.'], 403);
            }

            // Generate ICP
            $generatedIcp = $this->generatorService->generate($inputData);

            // Save to DB
            $icp = Icp::create([
                'user_id' => $user->id,
                'project_name' => $inputData['project_name'],
                'input_data' => $inputData,
                'generated_icp' => $generatedIcp,
                'status' => 'completed',
            ]);

            return response()->json([
                'success' => true,
                'redirect_url' => route('icp-builder.show', $icp->id),
            ]);

        } catch (\Exception $e) {
            Log::error('ICP Creation Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function show(Icp $icp)
    {
        if ($icp->user_id !== Auth::id()) {
            abort(403);
        }

        return view('tools.icp-builder.result', compact('icp'));
    }
}
