<?php

namespace App\Services;

use App\Models\Feature;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class FeatureAccessService
{
    /**
     * Check if user can access the feature.
     * Returns string status: 'allowed', 'inactive', 'insufficient_credits', 'not_found'
     */
    public function checkAccess(User $user, string $featureKey): array
    {
        $feature = Feature::where('key', $featureKey)->first();

        if (!$feature) {
            return ['status' => 'not_found', 'message' => 'Feature not found'];
        }

        if (!$feature->is_active) {
            return ['status' => 'inactive', 'message' => 'This feature is coming soon'];
        }

        // -1 means unlimited usage, no credit check needed
        if ($feature->credit_cost == -1) {
            return ['status' => 'allowed', 'feature' => $feature];
        }

        if ($user->credits < $feature->credit_cost) {
            return [
                'status' => 'insufficient_credits',
                'message' => "Insufficient credits. Required: {$feature->credit_cost}, Available: {$user->credits}",
                'cost' => $feature->credit_cost
            ];
        }

        return ['status' => 'allowed', 'feature' => $feature];
    }

    /**
     * Deduct credits for feature usage and log the transaction.
     * Returns true if successful, false otherwise.
     */
    public function deductCredits(User $user, string $featureKey, array $metadata = []): bool
    {
        $feature = Feature::where('key', $featureKey)->first();

        if (!$feature || !$feature->is_active) {
            $this->logUsage($user, $featureKey, 0, 0, 'inactive', $metadata); // Log attempts on inactive features
            return false;
        }

        // -1 means unlimited usage, no credit deduction needed
        if ($feature->credit_cost == -1) {
            $this->logUsage($user, $featureKey, 0, $user->credits, 'success', $metadata);
            return true;
        }

        // zero cost checks
        if ($feature->credit_cost == 0) {
            $this->logUsage($user, $featureKey, 0, $user->credits, 'success', $metadata);
            return true;
        }

        if ($user->credits < $feature->credit_cost) {
            $this->logUsage($user, $featureKey, 0, $user->credits, 'insufficient_credits', $metadata);
            return false;
        }

        $user->decrement('credits', $feature->credit_cost);
        $this->logUsage($user, $featureKey, $feature->credit_cost, $user->credits, 'success', $metadata);

        Log::info("Credits deducted for user {$user->id} using feature {$featureKey}: {$feature->credit_cost} credits.");

        return true;
    }

    /**
     * Log feature usage to database.
     */
    protected function logUsage(User $user, string $featureKey, int $deducted, int $remaining, string $status, array $metadata = []): void
    {
        \App\Models\FeatureUsage::create([
            'user_id' => $user->id,
            'feature_key' => $featureKey,
            'credits_deducted' => $deducted,
            'credits_remaining' => $remaining,
            'status' => $status,
            'metadata' => $metadata,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
