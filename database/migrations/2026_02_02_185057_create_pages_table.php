<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Interview Prep, Prompts, etc.
            $table->string('slug')->unique(); // interview-prep, prompts
            $table->string('route_name')->nullable(); // interview-prep.landing
            $table->boolean('is_active')->default(true);
            $table->boolean('show_in_navigation')->default(true);
            $table->integer('menu_order')->default(0);
            $table->enum('inactive_behavior', ['coming_soon', '404', 'redirect_home', 'maintenance'])->default('coming_soon');
            $table->timestamp('scheduled_activation')->nullable();
            $table->timestamp('scheduled_deactivation')->nullable();
            $table->json('access_restrictions')->nullable(); // roles, auth required, etc.
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
