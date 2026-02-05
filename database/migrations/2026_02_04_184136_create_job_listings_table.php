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
        Schema::create('job_listings', function (Blueprint $table) {
            $table->id();
            $table->string('job_title')->index();
            $table->string('company_name')->index();
            $table->string('location')->nullable();
            $table->string('job_type')->nullable();
            $table->string('experience_level')->nullable();
            $table->string('salary_range')->nullable();
            $table->foreignId('category_id')->constrained('job_categories')->onDelete('cascade');
            $table->boolean('is_featured')->default(false);
            $table->string('status')->default('active')->index();
            $table->integer('views_count')->default(0);
            $table->integer('applications_count')->default(0);
            $table->text('source_url')->nullable();
            $table->date('posted_date')->nullable();
            $table->date('expires_at')->nullable();
            $table->json('job_data')->nullable(); // stores structured AI data
            $table->string('slug')->unique();
            $table->json('metadata')->nullable(); // SEO
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_listings');
    }
};
