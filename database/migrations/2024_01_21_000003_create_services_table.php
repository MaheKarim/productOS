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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);

            // Service content fields
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('icon')->nullable();
            $table->string('icon_type')->default('fa-solid')->nullable(); // fa-solid, fa-regular, etc.
            $table->string('image')->nullable();

            // Problem and outcome
            $table->text('problem_solves')->nullable();
            $table->text('tangible_outcome')->nullable();

            // Features list (JSON)
            $table->json('features')->nullable();

            // CTA
            $table->string('cta_text')->nullable();
            $table->string('cta_url')->nullable();
            $table->string('cta_style')->default('primary')->nullable(); // primary, secondary

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
        Schema::dropIfExists('services');
    }
};
