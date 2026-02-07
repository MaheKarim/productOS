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
            $table->json('priority_summary')->nullable()->after('overall_score');
            $table->json('section_breakdown')->nullable()->after('priority_summary');
            $table->json('content_metrics')->nullable()->after('section_breakdown');
            $table->json('ats_checklist')->nullable()->after('content_metrics');
            $table->json('improvement_examples')->nullable()->after('ats_checklist');
            $table->json('contact_validation')->nullable()->after('improvement_examples');
            $table->json('resume_length')->nullable()->after('contact_validation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('resume_analyses', function (Blueprint $table) {
            $table->dropColumn([
                'priority_summary',
                'section_breakdown',
                'content_metrics',
                'ats_checklist',
                'improvement_examples',
                'contact_validation',
                'resume_length',
            ]);
        });
    }
};
