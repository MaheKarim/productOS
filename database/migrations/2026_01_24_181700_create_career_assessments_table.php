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
        Schema::create('career_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('session_id')->nullable()->index();

            // Environment scores (6 variables, 0-2 scale)
            $table->decimal('manager_score', 3, 2)->default(0);
            $table->decimal('resources_score', 3, 2)->default(0);
            $table->decimal('team_score', 3, 2)->default(0);
            $table->decimal('scope_score', 3, 2)->default(0);
            $table->decimal('compensation_score', 3, 2)->default(0);
            $table->decimal('culture_score', 3, 2)->default(0);

            // Skills scores (4 variables, 0-2 scale)
            $table->decimal('communication_score', 3, 2)->default(0);
            $table->decimal('leadership_score', 3, 2)->default(0);
            $table->decimal('strategy_score', 3, 2)->default(0);
            $table->decimal('execution_score', 3, 2)->default(0);

            // Calculated totals
            $table->decimal('environment_total', 4, 2)->default(0);
            $table->decimal('skills_total', 3, 2)->default(0);
            $table->decimal('impact_score', 5, 2)->default(0);

            $table->text('notes')->nullable();
            $table->timestamp('assessment_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('career_assessments');
    }
};
