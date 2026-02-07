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
        Schema::create('feedback_status_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('feedback_id')->constrained('feedback')->onDelete('cascade');
            $table->enum('old_status', ['submitted', 'under_review', 'planned', 'in_progress', 'resolved', 'closed'])->nullable();
            $table->enum('new_status', ['submitted', 'under_review', 'planned', 'in_progress', 'resolved', 'closed']);
            $table->foreignId('admin_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->text('admin_comment')->nullable();
            $table->boolean('is_visible_to_user')->default(true);
            $table->timestamps();

            // Indexes for performance
            $table->index('feedback_id');
            $table->index('admin_user_id');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedback_status_histories');
    }
};
