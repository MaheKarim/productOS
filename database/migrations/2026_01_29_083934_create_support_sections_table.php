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
        Schema::create('support_sections', function (Blueprint $table) {
            $table->id();
            $table->string('headline')->default('Enjoying These Tools?');
            $table->text('body_text')->nullable();
            $table->string('image_path')->nullable();
            $table->string('buymeacoffee_url')->nullable();
            $table->boolean('show_progress_bar')->default(false);
            $table->integer('progress_value')->default(0);
            $table->integer('progress_goal')->default(100);
            $table->string('progress_label')->nullable()->default('Support Goal');
            $table->string('twitter_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('support_sections');
    }
};
