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
        Schema::table('resume_analyses', function (Blueprint $table) {
            $table->unsignedBigInteger('job_id')->nullable()->after('user_id');
            $table->string('analysis_type')->default('general')->after('job_id');
            $table->decimal('confidence_score', 5, 2)->nullable()->after('overall_score');
            $table->json('job_description')->nullable()->after('raw_resume_text');
            $table->json('analysis_results')->nullable()->after('job_description');
            
            $table->foreign('job_id')->references('id')->on('job_listings')->onDelete('set null');
            $table->index(['user_id', 'job_id']);
            $table->index('analysis_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('resume_analyses', function (Blueprint $table) {
            $table->dropForeign(['job_id']);
            $table->dropIndex(['user_id', 'job_id']);
            $table->dropIndex(['analysis_type']);
            
            $table->dropColumn([
                'job_id',
                'analysis_type',
                'confidence_score',
                'job_description',
                'analysis_results',
            ]);
        });
    }
};