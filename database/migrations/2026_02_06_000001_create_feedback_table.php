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
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('feedback_id')->unique()->comment('e.g., FB-12345');
            $table->enum('type', ['bug', 'feature', 'satisfaction'])->default('bug');
            $table->string('title', 100);
            $table->text('description');
            $table->enum('status', ['submitted', 'under_review', 'planned', 'in_progress', 'resolved', 'closed'])->default('submitted');
            $table->enum('severity', ['critical', 'high', 'medium', 'low'])->nullable()->comment('For bug reports');
            $table->enum('priority', ['must_have', 'nice_to_have'])->nullable()->comment('For feature requests');
            $table->integer('satisfaction_rating')->nullable()->comment('1-5 or 1-10 for satisfaction feedback');
            $table->enum('satisfaction_category', ['design', 'performance', 'content', 'navigation', 'other'])->nullable();
            $table->text('whats_working')->nullable()->comment('For satisfaction feedback');
            $table->text('needs_improvement')->nullable()->comment('For satisfaction feedback');
            $table->text('steps_to_reproduce')->nullable()->comment('For bug reports');
            $table->text('expected_behavior')->nullable()->comment('For bug reports');
            $table->text('actual_behavior')->nullable()->comment('For bug reports');
            $table->text('use_case')->nullable()->comment('For feature requests');
            $table->string('page_url')->nullable();
            $table->text('browser_info')->nullable();
            $table->text('device_info')->nullable();
            $table->string('ip_address')->nullable();
            $table->boolean('is_withdrawn')->default(false);
            $table->timestamp('withdrawn_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Indexes for performance
            $table->index('user_id');
            $table->index('feedback_id');
            $table->index('type');
            $table->index('status');
            $table->index('created_at');
            $table->index('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedback');
    }
};
