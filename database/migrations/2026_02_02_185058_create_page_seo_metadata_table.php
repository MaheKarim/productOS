<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('page_seo_metadata', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->constrained()->cascadeOnDelete();

            // Basic SEO
            $table->string('title', 60)->nullable();
            $table->text('description')->nullable(); // 160 chars recommended
            $table->text('keywords')->nullable();
            $table->string('canonical_url')->nullable();
            $table->string('focus_keyword')->nullable();

            // Robots
            $table->enum('robots_index', ['index', 'noindex'])->default('index');
            $table->enum('robots_follow', ['follow', 'nofollow'])->default('follow');

            // Open Graph (for future expansion)
            $table->string('og_title')->nullable();
            $table->text('og_description')->nullable();
            $table->string('og_image')->nullable();
            $table->string('og_type')->default('website');

            // Twitter Card (for future expansion)
            $table->string('twitter_title')->nullable();
            $table->text('twitter_description')->nullable();
            $table->string('twitter_image')->nullable();
            $table->enum('twitter_card_type', ['summary', 'summary_large_image'])->default('summary_large_image');

            // Structured Data (for future expansion)
            $table->json('schema_markup')->nullable(); // JSON-LD

            // Sitemap
            $table->boolean('include_in_sitemap')->default(true);
            $table->decimal('sitemap_priority', 2, 1)->default(0.5);
            $table->enum('sitemap_frequency', ['always', 'hourly', 'daily', 'weekly', 'monthly', 'yearly', 'never'])->default('weekly');

            // Custom Scripts (for future expansion)
            $table->text('header_scripts')->nullable();
            $table->text('footer_scripts')->nullable();

            // SEO Health
            $table->integer('seo_score')->default(0); // 0-100
            $table->json('seo_issues')->nullable(); // Missing fields, warnings

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_seo_metadata');
    }
};
