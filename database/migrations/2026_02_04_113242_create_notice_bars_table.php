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
        Schema::create('notice_bars', function (Blueprint $table) {
            $table->id();
            $table->string('title', 60);
            $table->text('message');
            $table->boolean('dismissible')->default(true);
            $table->dateTime('expires_at')->nullable();
            $table->enum('audience', ['all', 'free', 'pro'])->default('all');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notice_bars');
    }
};
