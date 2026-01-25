<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AiProvider;
use App\Models\AiProviderModel;
use App\Services\AiProviderService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AiProviderController extends Controller
{
    protected AiProviderService $providerService;

    public function __construct(AiProviderService $providerService)
    {
        $this->providerService = $providerService;
    }

    /**
     * Display a listing of AI providers.
     */
    public function index()
    {
        $providers = AiProvider::with('models')->get();

        return view('admin.ai-providers.index', [
            'providers' => $providers,
        ]);
    }

    /**
     * Show the form for creating a new provider.
     */
    public function create()
    {
        $providerTypes = [
            'openrouter' => 'OpenRouter',
            'groq' => 'Groq',
            'zai' => 'Z.AI',
            'gemini' => 'Gemini / Google AI Studio',
        ];

        return view('admin.ai-providers.create', [
            'providerTypes' => $providerTypes,
            'defaultUrls' => [
                'openrouter' => AiProvider::getDefaultBaseUrl('openrouter'),
                'groq' => AiProvider::getDefaultBaseUrl('groq'),
                'zai' => AiProvider::getDefaultBaseUrl('zai'),
                'gemini' => AiProvider::getDefaultBaseUrl('gemini'),
            ],
            'predefinedModels' => [
                'openrouter' => AiProvider::getPredefinedModels('openrouter'),
                'groq' => AiProvider::getPredefinedModels('groq'),
                'zai' => AiProvider::getPredefinedModels('zai'),
                'gemini' => AiProvider::getPredefinedModels('gemini'),
            ],
        ]);
    }

    /**
     * Store a newly created provider.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'slug' => ['required', 'string', 'in:openrouter,groq,zai,gemini', Rule::unique('ai_providers', 'slug')],
            'api_key' => ['required', 'string', 'min:10'],
            'base_url' => ['required', 'url'],
            'default_model' => ['nullable', 'string'],
            'timeout' => ['nullable', 'integer', 'min:5', 'max:300'],
            'max_tokens' => ['nullable', 'integer', 'min:100', 'max:128000'],
            'rate_limit_per_minute' => ['nullable', 'integer', 'min:1', 'max:10000'],
            'description' => ['nullable', 'string', 'max:500'],
            'is_active' => ['nullable', 'boolean'],
            'is_default' => ['nullable', 'boolean'],
        ]);

        $providerNames = [
            'openrouter' => 'OpenRouter',
            'groq' => 'Groq',
            'zai' => 'Z.AI',
            'gemini' => 'Gemini / Google AI Studio',
        ];

        $provider = AiProvider::create([
            'name' => $providerNames[$validated['slug']],
            'slug' => $validated['slug'],
            'api_key' => $validated['api_key'],
            'base_url' => $validated['base_url'],
            'default_model' => $validated['default_model'] ?? null,
            'timeout' => $validated['timeout'] ?? 30,
            'max_tokens' => $validated['max_tokens'] ?? null,
            'rate_limit_per_minute' => $validated['rate_limit_per_minute'] ?? null,
            'description' => $validated['description'] ?? null,
            'is_active' => $request->boolean('is_active', true),
            'is_default' => $request->boolean('is_default', false),
        ]);

        // If set as default, unset others
        if ($provider->is_default) {
            $provider->setAsDefault();
        }

        return redirect()
            ->route('admin.ai-providers.index')
            ->with('success', 'AI Provider "' . $provider->name . '" created successfully.');
    }

    /**
     * Show the form for editing a provider.
     */
    public function edit(AiProvider $ai_provider)
    {
        $providerTypes = [
            'openrouter' => 'OpenRouter',
            'groq' => 'Groq',
            'zai' => 'Z.AI',
            'gemini' => 'Gemini / Google AI Studio',
        ];

        // Get discovered models from database
        $discoveredModels = $ai_provider->models()
            ->where('is_active', true)
            ->orderBy('model_name')
            ->get();

        return view('admin.ai-providers.edit', [
            'provider' => $ai_provider,
            'providerTypes' => $providerTypes,
            'predefinedModels' => AiProvider::getPredefinedModels($ai_provider->slug),
            'discoveredModels' => $discoveredModels,
        ]);
    }

    /**
     * Update the specified provider.
     */
    public function update(Request $request, AiProvider $ai_provider)
    {
        $validated = $request->validate([
            'api_key' => ['nullable', 'string', 'min:10'],
            'base_url' => ['required', 'url'],
            'default_model' => ['nullable', 'string'],
            'timeout' => ['nullable', 'integer', 'min:5', 'max:300'],
            'max_tokens' => ['nullable', 'integer', 'min:100', 'max:128000'],
            'rate_limit_per_minute' => ['nullable', 'integer', 'min:1', 'max:10000'],
            'description' => ['nullable', 'string', 'max:500'],
            'is_active' => ['nullable', 'boolean'],
            'is_default' => ['nullable', 'boolean'],
        ]);

        $updateData = [
            'base_url' => $validated['base_url'],
            'default_model' => $validated['default_model'] ?? null,
            'timeout' => $validated['timeout'] ?? 30,
            'max_tokens' => $validated['max_tokens'] ?? null,
            'rate_limit_per_minute' => $validated['rate_limit_per_minute'] ?? null,
            'description' => $validated['description'] ?? null,
            'is_active' => $request->boolean('is_active', true),
            'is_default' => $request->boolean('is_default', false),
        ];

        // Only update API key if provided
        if (!empty($validated['api_key'])) {
            $updateData['api_key'] = $validated['api_key'];
        }

        $ai_provider->update($updateData);

        // If set as default, unset others
        if ($ai_provider->is_default) {
            $ai_provider->setAsDefault();
        }

        return redirect()
            ->route('admin.ai-providers.index')
            ->with('success', 'AI Provider "' . $ai_provider->name . '" updated successfully.');
    }

    /**
     * Remove the specified provider.
     */
    public function destroy(AiProvider $ai_provider)
    {
        $name = $ai_provider->name;
        $ai_provider->delete();

        return redirect()
            ->route('admin.ai-providers.index')
            ->with('success', 'AI Provider "' . $name . '" deleted successfully.');
    }

    /**
     * Toggle provider active status.
     */
    public function toggleActive(AiProvider $provider)
    {
        $provider->update(['is_active' => !$provider->is_active]);

        $status = $provider->is_active ? 'activated' : 'deactivated';

        return back()->with('success', 'Provider "' . $provider->name . '" ' . $status . '.');
    }

    /**
     * Set provider as default.
     */
    public function setDefault(AiProvider $provider)
    {
        $provider->setAsDefault();

        return back()->with('success', 'Provider "' . $provider->name . '" set as default.');
    }

    /**
     * Test connection to provider.
     */
    public function testConnection(AiProvider $provider)
    {
        $result = $this->providerService->testConnection($provider);

        if ($result['success']) {
            // Auto-discover and save available models
            $discoveryResult = $this->providerService->discoverAndSaveModels($provider);

            $message = $result['message'];
            if ($discoveryResult['saved_count'] > 0) {
                $message .= " Discovered and saved {$discoveryResult['saved_count']} new models.";
            } elseif ($discoveryResult['models_count'] > 0) {
                $message .= " {$discoveryResult['models_count']} models already configured.";
            }

            return back()->with('success', $message);
        }

        return back()->with('error', $result['message']);
    }

    /**
     * Manage models for a provider.
     */
    public function models(AiProvider $provider)
    {
        return view('admin.ai-providers.models', [
            'provider' => $provider,
            'models' => $provider->models,
            'predefinedModels' => AiProvider::getPredefinedModels($provider->slug),
        ]);
    }

    /**
     * Store a model for a provider.
     */
    public function storeModel(Request $request, AiProvider $provider)
    {
        $validated = $request->validate([
            'model_name' => [
                'required',
                'string',
                Rule::unique('ai_provider_models')->where(function ($query) use ($provider) {
                    return $query->where('ai_provider_id', $provider->id);
                })
            ],
            'display_name' => ['nullable', 'string', 'max:100'],
            'rate_limit_per_minute' => ['nullable', 'integer', 'min:1', 'max:10000'],
            'max_tokens_limit' => ['nullable', 'integer', 'min:100', 'max:128000'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $provider->models()->create([
            'model_name' => $validated['model_name'],
            'display_name' => $validated['display_name'] ?? null,
            'rate_limit_per_minute' => $validated['rate_limit_per_minute'] ?? null,
            'max_tokens_limit' => $validated['max_tokens_limit'] ?? null,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return back()->with('success', 'Model added successfully.');
    }

    /**
     * Delete a model.
     */
    public function destroyModel(AiProvider $provider, AiProviderModel $model)
    {
        $model->delete();

        return back()->with('success', 'Model removed successfully.');
    }
}
