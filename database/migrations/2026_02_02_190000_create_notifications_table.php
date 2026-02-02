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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('message');
            $table->enum('type', ['system', 'feature', 'promotional', 'alert', 'personal', 'credit'])->default('system');
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->string('icon_class')->nullable();
            $table->string('color_code')->nullable();
            $table->string('action_text')->nullable();
            $table->string('action_url')->nullable();
            $table->enum('target_type', ['all', 'specific', 'role', 'custom'])->default('all');
            $table->json('target_users')->nullable();
            $table->string('target_role')->nullable();
            $table->enum('status', ['draft', 'scheduled', 'active', 'expired'])->default('draft');
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->boolean('is_dismissible')->default(true);
            $table->boolean('is_persistent')->default(false);
            $table->boolean('show_as_popup')->default(false);
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Indexes for performance
            $table->index('status');
            $table->index('type');
            $table->index('scheduled_at');
            $table->index('expires_at');
            $table->index('created_at');
            $table->index('created_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
