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
        Schema::table('videos', function (Blueprint $table) {
            // Transcript fetch tracking
            $table->integer('transcript_fetch_attempts')->default(0)->after('transcript');
            $table->text('transcript_fetch_error')->nullable()->after('transcript_fetch_attempts');
            $table->timestamp('transcript_fetched_at')->nullable()->after('transcript_fetch_error');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->dropColumn([
                'transcript_fetch_attempts',
                'transcript_fetch_error',
                'transcript_fetched_at'
            ]);
        });
    }
};
