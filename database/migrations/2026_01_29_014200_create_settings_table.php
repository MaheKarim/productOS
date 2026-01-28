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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('group')->index()->comment('Category of the setting (e.g., general, seo, social)');
            $table->string('key')->unique()->comment('Unique identifier for the setting');
            $table->text('value')->nullable()->comment('The value of the setting');
            $table->string('type')->default('string')->comment('Data type (string, boolean, integer, image, json)');
            $table->string('label')->nullable()->comment('Human readable label');
            $table->text('description')->nullable()->comment('Helper text for the admin');
            $table->boolean('is_locked')->default(false)->comment('If true, cannot be deleted from admin panel');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
