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
        Schema::create('directory_items', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->enum('type', ['tools', 'learning', 'companies', 'communities', 'templates']);
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('tagline')->nullable();
            $table->longText('description')->nullable();
            $table->string('logo_path')->nullable();
            $table->string('website_url')->nullable();
            $table->string('external_url')->nullable();

            // Categorization
            $table->string('category')->nullable();
            $table->json('sub_categories')->nullable();
            $table->json('tags')->nullable();

            // Pricing (Tools & Learning)
            $table->enum('pricing_model', ['free', 'freemium', 'paid', 'enterprise'])->nullable();
            $table->string('price_range')->nullable();
            $table->boolean('bd_available')->default(false);
            $table->json('payment_methods')->nullable();

            // Features
            $table->json('key_features')->nullable();
            $table->json('pros')->nullable();
            $table->json('cons')->nullable();
            $table->json('use_cases')->nullable();

            // Learning Specific
            $table->enum('content_type', ['course', 'book', 'video', 'podcast', 'blog'])->nullable();
            $table->enum('language', ['bangla', 'english', 'both'])->nullable();
            $table->enum('difficulty_level', ['beginner', 'intermediate', 'advanced', 'all'])->nullable();
            $table->string('duration')->nullable();
            $table->string('instructor')->nullable();
            $table->string('platform')->nullable();
            $table->boolean('certificate')->default(false);

            // Companies Specific
            $table->enum('company_size', ['1-10', '11-50', '51-200', '201-500', '500+'])->nullable();
            $table->string('industry')->nullable();
            $table->string('location')->nullable();
            $table->string('product_type')->nullable();
            $table->boolean('is_hiring')->default(false);
            $table->string('salary_range')->nullable();
            $table->string('application_url')->nullable();
            $table->text('application_tips')->nullable();
            $table->enum('remote_policy', ['onsite', 'hybrid', 'remote', 'flexible'])->nullable();

            // Communities Specific
            $table->string('member_count')->nullable();
            $table->enum('activity_level', ['very_active', 'active', 'moderate', 'low'])->nullable();
            $table->string('join_url')->nullable();

            // Templates Specific
            $table->enum('template_type', ['prd', 'presentation', 'framework', 'checklist', 'other'])->nullable();
            $table->string('file_format')->nullable();
            $table->string('download_url')->nullable();
            $table->string('preview_url')->nullable();

            // Engagement
            $table->integer('view_count')->default(0);
            $table->integer('click_count')->default(0);
            $table->integer('bookmark_count')->default(0);

            // Admin & Meta
            $table->enum('verification_status', ['pending', 'verified', 'rejected'])->default('pending');
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->dateTime('featured_until')->nullable();
            $table->foreignId('submitted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('admin_notes')->nullable();
            $table->string('seo_title')->nullable();
            $table->string('seo_description', 500)->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('name');
            $table->index(['type', 'is_active']);
            $table->index(['type', 'category']);
            $table->index('is_featured');
            $table->index('is_hiring');
            $table->index('verification_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('directory_items');
    }
};
