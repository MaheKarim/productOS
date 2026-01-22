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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);

            // Project content fields
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('category')->nullable(); // B2B SaaS, Consumer App, Fintech, etc.
            $table->string('external_link')->nullable();

            // Metrics
            $table->string('metric_value')->nullable(); // e.g., +89%
            $table->string('metric_label')->nullable(); // e.g., Trial Conversion
            $table->string('duration')->nullable(); // e.g., 6 months
            $table->string('users')->nullable(); // e.g., 47K users

            // Tags
            $table->json('tags')->nullable();

            // Related tools
            $table->json('related_tools')->nullable();

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
        Schema::dropIfExists('projects');
    }
};
