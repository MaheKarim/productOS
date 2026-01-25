<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Crypt;

class AiProvider extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'api_key',
        'base_url',
        'default_model',
        'is_active',
        'is_default',
        'timeout',
        'max_tokens',
        'rate_limit_per_minute',
        'settings',
        'description',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'is_default' => 'boolean',
        'settings' => 'array',
        'timeout' => 'integer',
        'max_tokens' => 'integer',
        'rate_limit_per_minute' => 'integer',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<string>
     */
    protected $hidden = [
        'api_key',
    ];

    /**
     * Encrypt API key when setting.
     */
    public function setApiKeyAttribute($value): void
    {
        if ($value) {
            $this->attributes['api_key'] = Crypt::encryptString($value);
        }
    }

    /**
     * Decrypt API key when getting.
     */
    public function getApiKeyAttribute($value): ?string
    {
        if ($value) {
            try {
                return Crypt::decryptString($value);
            } catch (\Exception $e) {
                return null;
            }
        }
        return null;
    }

    /**
     * Get masked API key for display (shows last 4 characters).
     */
    public function getMaskedApiKey(): string
    {
        $key = $this->api_key;
        if (!$key || strlen($key) < 8) {
            return '••••••••';
        }
        return '••••••••' . substr($key, -4);
    }

    /**
     * Get the models for this provider.
     */
    public function models(): HasMany
    {
        return $this->hasMany(AiProviderModel::class);
    }

    /**
     * Scope to get only active providers.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get the default active provider.
     */
    public static function getDefault(): ?self
    {
        return static::active()->where('is_default', true)->first();
    }

    /**
     * Get fallback provider (first active non-default).
     */
    public static function getFallback(): ?self
    {
        return static::active()->where('is_default', false)->first();
    }

    /**
     * Set this provider as the default (and unset others).
     */
    public function setAsDefault(): void
    {
        static::where('id', '!=', $this->id)->update(['is_default' => false]);
        $this->update(['is_default' => true]);
    }

    /**
     * Get default base URLs for providers.
     */
    public static function getDefaultBaseUrl(string $slug): string
    {
        return match ($slug) {
            'openrouter' => 'https://openrouter.ai/api/v1',
            'groq' => 'https://api.groq.com/openai/v1',
            'zai' => 'https://api.z.ai/api/paas/v4',
            'gemini' => 'https://generativelanguage.googleapis.com/v1beta',
            default => '',
        };
    }

    /**
     * Get predefined models for each provider.
     */
    public static function getPredefinedModels(string $slug): array
    {
        return match ($slug) {
            'openrouter' => [
                'openai/gpt-4-turbo' => 'GPT-4 Turbo',
                'openai/gpt-4o' => 'GPT-4o',
                'openai/gpt-4o-mini' => 'GPT-4o Mini',
                'anthropic/claude-3.5-sonnet' => 'Claude 3.5 Sonnet',
                'anthropic/claude-3-opus' => 'Claude 3 Opus',
                'google/gemini-pro-1.5' => 'Gemini Pro 1.5',
                'meta-llama/llama-3.1-70b-instruct' => 'Llama 3.1 70B',
                'meta-llama/llama-3.1-405b-instruct' => 'Llama 3.1 405B',
            ],
            'groq' => [
                'llama-3.3-70b-versatile' => 'Llama 3.3 70B Versatile',
                'llama-3.1-70b-versatile' => 'Llama 3.1 70B Versatile',
                'llama-3.1-8b-instant' => 'Llama 3.1 8B Instant',
                'mixtral-8x7b-32768' => 'Mixtral 8x7B',
                'gemma2-9b-it' => 'Gemma 2 9B',
            ],
            'zai' => [
                'glm-4.7' => 'GLM-4.7 (Flagship)',
                'glm-4.6v' => 'GLM-4.6V (Multimodal)',
                'glm-4.5' => 'GLM-4.5 (355B MoE)',
                'glm-4.5-air' => 'GLM-4.5-Air (106B)',
                'glm-4.5-x' => 'GLM-4.5-X (Fast)',
            ],
            'gemini' => [
                'gemini-2.0-flash-exp' => 'Gemini 2.0 Flash (Experimental)',
                'gemini-1.5-pro-latest' => 'Gemini 1.5 Pro (Latest)',
                'gemini-1.5-flash-latest' => 'Gemini 1.5 Flash (Latest)',
                'gemini-1.5-pro' => 'Gemini 1.5 Pro',
                'gemini-1.5-flash' => 'Gemini 1.5 Flash',
                'gemini-1.0-pro' => 'Gemini 1.0 Pro',
            ],
            default => [],
        };
    }
}
