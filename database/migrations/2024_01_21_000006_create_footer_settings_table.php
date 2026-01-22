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
        Schema::create('footer_settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);

            // Footer content fields
            $table->string('logo_text')->nullable();
            $table->text('description')->nullable();
            $table->string('logo_image')->nullable();

            // Social media links
            $table->string('linkedin_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('github_url')->nullable();
            $table->string('email')->nullable();

            // Quick links columns
            $table->json('column1_links')->nullable(); // Case Studies
            $table->json('column2_links')->nullable(); // Tools
            $table->json('column3_links')->nullable(); // Connect

            // Copyright
            $table->string('copyright_text')->nullable();

            // Additional links
            $table->string('privacy_policy_url')->nullable();
            $table->string('terms_url')->nullable();

            // SEO fields
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('footer_settings');
    }
};
