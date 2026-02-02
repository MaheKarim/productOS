<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('page_analytics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->constrained()->cascadeOnDelete();
            $table->date('date');
            $table->integer('views')->default(0);
            $table->integer('unique_visitors')->default(0);
            $table->decimal('avg_time_on_page', 8, 2)->default(0); // seconds
            $table->decimal('bounce_rate', 5, 2)->default(0); // percentage
            $table->timestamps();

            $table->unique(['page_id', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_analytics');
    }
};
