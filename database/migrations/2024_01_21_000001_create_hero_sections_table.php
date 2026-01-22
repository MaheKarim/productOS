<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hero_sections', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
            
            // Hero content fields
            $table->string('badge_text')->nullable();
            $table->string('title');
            $table->text('subtitle')->nullable();
            $table->string('cta_primary_text')->nullable();
            $table->string('cta_primary_url')->nullable();
            $table->string('cta_secondary_text')->nullable();
            $table->string('cta_secondary_url')->nullable();
            $table->string('background_image')->nullable();
            $table->string('profile_image')->nullable();
            
            // Stats
            $table->string('stat1_icon')->nullable();
            $table->string('stat1_value')->nullable();
            $table->string('stat1_label')->nullable();
            $table->string('stat2_icon')->nullable();
            $table->string('stat2_value')->nullable();
            $table->string('stat2_label')->nullable();
            $table->string('stat3_icon')->nullable();
            $table->string('stat3_value')->nullable();
            $table->string('stat3_label')->nullable();
            
            // Floating cards
            $table->string('floating_card1_icon')->nullable();
            $table->string('floating_card1_title')->nullable();
            $table->string('floating_card1_subtitle')->nullable();
            $table->string('floating_card2_icon')->nullable();
            $table->string('floating_card2_title')->nullable();
            $table->string('floating_card2_subtitle')->nullable();
            
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
        Schema::dropIfExists('hero_sections');
    }
};
