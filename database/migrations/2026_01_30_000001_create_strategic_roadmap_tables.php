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
        // Roadmap Sessions - tracks user input collection
        Schema::create('roadmap_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->uuid('session_uuid')->unique();
            $table->enum('user_level', ['junior', 'mid', 'senior'])->default('junior');

            // Product context
            $table->string('product_type')->nullable(); // saas, marketplace, ecommerce, mobile_app, other
            $table->string('product_stage')->nullable(); // idea, mvp, growth, scale, mature
            $table->string('team_size')->nullable(); // 1-5, 6-15, 16-50, 50+
            $table->string('funding_stage')->nullable(); // bootstrapped, seed, series_a, series_b_plus, profitable
            $table->string('mrr_range')->nullable(); // 0, 1-10k, 10-50k, 50-200k, 200k-1m, 1m+

            // Strategic context
            $table->json('challenges')->nullable(); // Array of challenge types
            $table->json('priorities')->nullable(); // Ordered array of priorities
            $table->json('current_metrics')->nullable(); // Current metric tracking status
            $table->json('input_context')->nullable(); // All additional inputs as JSONB

            // AI processing
            $table->string('ai_model_used')->nullable();
            $table->enum('complexity_level', ['basic', 'standard', 'advanced'])->default('basic');
            $table->enum('status', ['draft', 'generating', 'completed', 'failed'])->default('draft');
            $table->text('error_message')->nullable();

            $table->timestamps();

            $table->index(['user_id', 'status']);
            $table->index(['session_uuid']);
        });

        // Roadmap Outputs - stores generated roadmaps at different complexity levels
        Schema::create('roadmap_outputs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_id')->constrained('roadmap_sessions')->onDelete('cascade');

            // Multi-level outputs
            $table->json('simplified_version')->nullable(); // For Junior PMs - 90-day action plan
            $table->json('detailed_version')->nullable(); // For Mid-level - Quarterly OKR roadmap
            $table->json('strategic_version')->nullable(); // For Senior/Founders - Annual framework

            // Framework & benchmarks
            $table->json('metric_framework')->nullable(); // Recommended metrics (AARRR, HEART, etc)
            $table->json('benchmarks')->nullable(); // Industry benchmarks for comparison
            $table->json('execution_toolkit')->nullable(); // Tools and templates

            // Metadata
            $table->integer('generation_time_ms')->nullable();
            $table->integer('token_count')->nullable();

            $table->timestamps();

            $table->index(['session_id']);
        });

        // User Roadmap Progress - tracks user progress on roadmap items
        Schema::create('user_roadmap_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('output_id')->constrained('roadmap_outputs')->onDelete('cascade');

            // Progress tracking
            $table->json('checkpoints_completed')->nullable(); // Array of completed checkpoint IDs
            $table->json('metrics_updated')->nullable(); // Current metric values entered by user
            $table->json('notes')->nullable(); // User notes per section

            $table->integer('completion_percentage')->default(0);
            $table->timestamp('last_reviewed')->nullable();

            $table->timestamps();

            $table->unique(['user_id', 'output_id']);
            $table->index(['user_id']);
        });

        // Admin Roadmap Insights - analytics data for admin dashboard
        Schema::create('admin_roadmap_insights', function (Blueprint $table) {
            $table->id();
            $table->string('metric_name'); // e.g., 'sessions_by_level', 'completion_rate'
            $table->string('user_segment')->nullable(); // junior, mid, senior, all
            $table->string('dimension')->nullable(); // Additional grouping dimension
            $table->decimal('value', 10, 4);
            $table->enum('insight_type', ['usage', 'success', 'failure', 'trend'])->default('usage');
            $table->date('recorded_date');
            $table->timestamps();

            $table->index(['metric_name', 'recorded_date']);
            $table->index(['user_segment', 'recorded_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_roadmap_insights');
        Schema::dropIfExists('user_roadmap_progress');
        Schema::dropIfExists('roadmap_outputs');
        Schema::dropIfExists('roadmap_sessions');
    }
};
