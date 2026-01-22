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
        Schema::create('about_sections', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);

            // About content fields
            $table->string('heading');
            $table->text('description')->nullable();
            $table->string('image')->nullable();

            // Philosophy items
            $table->string('philosophy1_title')->nullable();
            $table->text('philosophy1_description')->nullable();
            $table->string('philosophy2_title')->nullable();
            $table->text('philosophy2_description')->nullable();
            $table->string('philosophy3_title')->nullable();
            $table->text('philosophy3_description')->nullable();
            $table->string('philosophy4_title')->nullable();
            $table->text('philosophy4_description')->nullable();

            // How I work items
            $table->string('work_item1')->nullable();
            $table->string('work_item2')->nullable();
            $table->string('work_item3')->nullable();
            $table->string('work_item4')->nullable();

            // Core values
            $table->string('core_value1')->nullable();
            $table->string('core_value2')->nullable();
            $table->string('core_value3')->nullable();
            $table->string('core_value4')->nullable();

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
        Schema::dropIfExists('about_sections');
    }
};
