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
        Schema::create('roadmap_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->integer('order')->default(0);
            $table->string('color')->nullable(); // e.g. text-blue-500 or hex
            $table->string('icon')->nullable(); // lucid icon name
            $table->timestamps();
        });

        Schema::create('roadmap_topics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('roadmap_categories')->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->tinyInteger('difficulty_level')->default(1); // 1-5
            $table->json('resources')->nullable(); // Array of links/books
            $table->timestamps();
        });

        Schema::create('roadmap_user_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('topic_id')->constrained('roadmap_topics')->onDelete('cascade');
            $table->tinyInteger('status')->default(0); // 0: Not Started, 1: In Progress, 2: Completed, 3: Mastered
            $table->timestamp('completed_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'topic_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roadmap_user_progress');
        Schema::dropIfExists('roadmap_topics');
        Schema::dropIfExists('roadmap_categories');
    }
};
