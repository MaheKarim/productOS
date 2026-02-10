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
        Schema::create('sitemap_items', function (Blueprint $table) {
            $table->id();
            $table->string('url');
            $table->string('name')->nullable();
            $table->enum('type', ['static', 'dynamic', 'external'])->default('static');
            $table->string('changefreq')->default('weekly');
            $table->decimal('priority', 2, 1)->default(0.5);
            $table->timestamp('lastmod')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('source_model')->nullable();
            $table->string('source_route')->nullable();
            $table->integer('sort_order')->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['is_active', 'type']);
            $table->index('sort_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sitemap_items');
    }
};
