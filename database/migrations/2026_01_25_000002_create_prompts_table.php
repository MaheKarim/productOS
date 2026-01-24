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
        Schema::create('prompts', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('slug')->unique();

            // Required fields
            $table->string('title');
            $table->longText('prompt_text'); // The actual prompt with markdown support
            $table->foreignId('category_id')->constrained('prompt_categories')->onDelete('cascade');
            $table->enum('ai_tool', ['chatgpt', 'claude', 'gemini', 'universal'])->default('universal');
            $table->json('use_case_tags')->nullable(); // ['roadmap', 'PRD', 'user-story', etc.]
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');

            // Optional fields
            $table->text('description')->nullable(); // Short 1-2 sentence description
            $table->longText('example_output')->nullable(); // What this prompt generates
            $table->string('author')->nullable(); // Contributor name
            $table->enum('difficulty_level', ['beginner', 'intermediate', 'advanced'])->default('intermediate');
            $table->enum('output_length', ['short', 'medium', 'long'])->default('medium');
            $table->json('related_prompt_ids')->nullable(); // Links to similar prompts
            $table->json('tips')->nullable(); // Tips for best results

            // Analytics & Tracking
            $table->unsignedInteger('copy_count')->default(0);
            $table->unsignedInteger('view_count')->default(0);
            $table->boolean('is_featured')->default(false);

            // SEO
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->json('seo_keywords')->nullable();

            // System fields
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();

            // Indexes for search performance
            $table->index(['status', 'is_featured']);
            $table->index('category_id');
            $table->index('ai_tool');
            // Note: Full-text search is handled in the model's search() scope using LIKE queries
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prompts');
    }
};
