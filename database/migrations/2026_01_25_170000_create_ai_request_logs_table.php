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
        Schema::create('ai_request_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ai_provider_id')->constrained('ai_providers')->onDelete('cascade');
            $table->string('model'); // The model used for the request
            $table->enum('status', ['success', 'error'])->default('success');
            $table->integer('response_time_ms'); // Response time in milliseconds
            $table->integer('input_tokens')->nullable(); // Input token count
            $table->integer('output_tokens')->nullable(); // Output token count
            $table->decimal('cost', 10, 6)->default(0); // Cost in USD
            $table->text('error_message')->nullable(); // Error details if failed
            $table->string('endpoint')->nullable(); // API endpoint called
            $table->json('metadata')->nullable(); // Additional request metadata
            $table->timestamps();

            // Indexes for efficient querying
            $table->index(['ai_provider_id', 'created_at']);
            $table->index(['model', 'created_at']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_request_logs');
    }
};
