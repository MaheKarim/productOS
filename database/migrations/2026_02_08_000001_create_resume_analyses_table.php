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
        Schema::create('resume_analyses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('file_name')->nullable();
            $table->unsignedTinyInteger('overall_score')->default(0)->comment('ATS score 0-100');
            $table->json('missing_sections')->nullable();
            $table->json('keyword_suggestions')->nullable();
            $table->json('formatting_issues')->nullable();
            $table->json('section_scores')->nullable()->comment('Individual section quality scores');
            $table->json('recommendations')->nullable()->comment('Prioritized improvement recommendations');
            $table->json('action_verbs')->nullable()->comment('Suggested action verbs');
            $table->text('raw_resume_text')->nullable();
            $table->timestamps();

            // Indexes
            $table->index('user_id');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resume_analyses');
    }
};
