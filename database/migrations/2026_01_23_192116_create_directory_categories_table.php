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
        Schema::create('directory_categories', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['tools', 'learning', 'companies', 'communities', 'templates']);
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('icon')->nullable();
            $table->string('color_class')->nullable()->default('bg-blue-500');
            $table->integer('display_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->integer('item_count')->default(0);
            $table->timestamps();

            $table->index(['type', 'slug', 'is_active', 'display_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('directory_categories');
    }
};
