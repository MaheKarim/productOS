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
        // 1. Videos Table
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('youtube_url');
            $table->string('video_id_str')->unique(); // YouTube Video ID (e.g. dQw4w9WgXcQ)

            // Channel Info
            $table->string('channel_name')->nullable();
            $table->string('channel_logo')->nullable();
            $table->string('channel_id')->nullable();

            // Video Metadata
            $table->string('title')->nullable();
            $table->string('thumbnail_url')->nullable();
            $table->timestamp('upload_date')->nullable();
            $table->string('duration')->nullable(); // ISO 8601 or seconds? storing as string is safest for now
            $table->unsignedBigInteger('view_count')->nullable();

            // Content
            $table->longText('transcript')->nullable(); // Can be very large

            // System
            $table->enum('access_level', ['free', 'premium'])->default('free');
            $table->enum('processing_status', ['pending', 'processing', 'completed', 'failed'])->default('pending');
            $table->foreignId('ai_provider_id')->nullable()->constrained('ai_providers')->nullOnDelete();

            $table->timestamps();
        });

        // 2. Topics Table
        Schema::create('topics', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->json('keywords')->nullable(); // For auto-classification
            $table->foreignId('parent_id')->nullable()->constrained('topics')->nullOnDelete();
            $table->text('description')->nullable();
            $table->json('metadata')->nullable(); // color, icon, etc.
            $table->timestamps();
        });

        // 3. AI Outputs Table
        Schema::create('ai_outputs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('video_id')->constrained('videos')->cascadeOnDelete();

            $table->text('summary_english')->nullable();
            $table->text('summary_bangla')->nullable();

            $table->json('actionable_skills')->nullable();
            $table->json('faqs')->nullable(); // Array of questions with timestamps
            $table->json('key_insights')->nullable();
            $table->text('read_reason')->nullable();

            $table->timestamp('generated_at')->useCurrent();
            $table->timestamps();
        });

        // 4. Video Topics Pivot Table
        Schema::create('video_topics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('video_id')->constrained('videos')->cascadeOnDelete();
            $table->foreignId('topic_id')->constrained('topics')->cascadeOnDelete();

            $table->float('confidence_score')->default(0);
            $table->boolean('is_verified')->default(false); // Manually verified

            $table->timestamps();

            $table->unique(['video_id', 'topic_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('video_topics');
        Schema::dropIfExists('ai_outputs');
        Schema::dropIfExists('topics');
        Schema::dropIfExists('videos');
    }
};
