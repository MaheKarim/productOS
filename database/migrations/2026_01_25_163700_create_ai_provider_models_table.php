<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ai_provider_models', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ai_provider_id')->constrained('ai_providers')->onDelete('cascade');
            $table->string('model_name'); // e.g., "gpt-4", "llama-3.1-70b"
            $table->string('display_name')->nullable(); // Human-readable name
            $table->integer('rate_limit_per_minute')->nullable(); // Per-model rate limit
            $table->integer('max_tokens_limit')->nullable(); // Per-model max tokens
            $table->decimal('cost_per_1k_input', 10, 6)->nullable(); // Cost tracking
            $table->decimal('cost_per_1k_output', 10, 6)->nullable(); // Cost tracking
            $table->boolean('is_active')->default(true); // Enable/disable model
            $table->json('settings')->nullable(); // Model-specific settings
            $table->timestamps();

            // Unique constraint per provider
            $table->unique(['ai_provider_id', 'model_name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_provider_models');
    }
};
