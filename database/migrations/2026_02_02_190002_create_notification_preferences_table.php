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
        Schema::create('notification_preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Global toggle
            $table->boolean('enable_notifications')->default(true);

            // Notification type preferences
            $table->boolean('receive_system')->default(true);
            $table->boolean('receive_features')->default(true);
            $table->boolean('receive_promotional')->default(true);
            $table->boolean('receive_alerts')->default(true);
            $table->boolean('receive_personal')->default(true);
            $table->boolean('receive_credit')->default(true);

            // Display preferences
            $table->boolean('show_popups')->default(true);
            $table->boolean('auto_mark_read')->default(true);
            $table->boolean('group_by_date')->default(true);

            // Cleanup preferences
            $table->integer('auto_archive_after_days')->default(30);
            $table->integer('auto_delete_after_days')->default(90);

            $table->timestamps();

            // Ensure one preference record per user
            $table->unique('user_id');
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_preferences');
    }
};
