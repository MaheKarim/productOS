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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('author')->nullable();
            $table->string('file_path');
            $table->integer('total_pages')->default(0);
            $table->enum('status', ['pending', 'extracting', 'ready', 'processing', 'completed', 'failed'])->default('pending');
            $table->text('error_message')->nullable();
            $table->timestamps();
        });

        Schema::create('book_chapters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->constrained()->cascadeOnDelete();
            $table->string('title')->nullable(); // "Chapter 1" or "Pages 1-10"
            $table->longText('content');
            $table->integer('order')->default(0);
            $table->integer('start_page')->nullable();
            $table->integer('end_page')->nullable();
            $table->timestamps();
        });

        Schema::create('book_summaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->constrained()->cascadeOnDelete();
            $table->foreignId('book_chapter_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('ai_provider_id')->nullable()->constrained(); // Optional relation if we want to track provider
            $table->string('type')->default('full'); // 'full', 'chapter'
            $table->longText('summary')->nullable();
            $table->longText('translation_bn')->nullable();
            $table->json('usage_data')->nullable(); // To store tokens/cost
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_summaries');
        Schema::dropIfExists('book_chapters');
        Schema::dropIfExists('books');
    }
};
