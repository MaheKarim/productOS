<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('case_studies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('industry')->nullable();
            $table->string('headline_metric')->nullable();
            $table->text('problem')->nullable();
            $table->text('strategy')->nullable();
            $table->json('implementation')->nullable();
            $table->json('results')->nullable();
            $table->json('tools_used')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('case_studies');
    }
};
