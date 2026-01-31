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
        // Question Categories table
        Schema::create('question_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('color')->default('#7C3AED'); // Default purple
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Questions table
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->text('question');
            $table->json('answers'); // ["A", "B", "C", "D"]
            $table->string('correct_answer')->nullable(); // The correct answer key
            $table->text('explanation')->nullable(); // Explanation for the answer
            $table->enum('difficulty', ['easy', 'medium', 'hard'])->default('medium');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Pivot table for many-to-many relationship
        Schema::create('category_question', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_category_id')->constrained('question_categories')->onDelete('cascade');
            $table->foreignId('question_id')->constrained('questions')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['question_category_id', 'question_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_question');
        Schema::dropIfExists('questions');
        Schema::dropIfExists('question_categories');
    }
};
