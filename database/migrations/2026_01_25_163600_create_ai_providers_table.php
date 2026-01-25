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
        Schema::create('ai_providers', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Display name (e.g., "OpenRouter", "Groq")
            $table->string('slug')->unique(); // Identifier (e.g., "openrouter", "groq")
            $table->text('api_key'); // Encrypted API key
            $table->string('base_url'); // API base URL
            $table->string('default_model')->nullable(); // Default model for this provider
            $table->boolean('is_active')->default(true); // Enable/disable provider
            $table->boolean('is_default')->default(false); // Set as primary provider
            $table->integer('timeout')->default(30); // Request timeout in seconds
            $table->integer('max_tokens')->nullable(); // Max tokens limit
            $table->integer('rate_limit_per_minute')->nullable(); // Rate limit per minute
            $table->json('settings')->nullable(); // Additional provider-specific settings
            $table->text('description')->nullable(); // Provider description
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_providers');
    }
};
