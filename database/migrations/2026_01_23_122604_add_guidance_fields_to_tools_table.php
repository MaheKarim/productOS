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
        Schema::table('tools', function (Blueprint $table) {
            $table->text('problem_solved')->nullable()->after('content');
            $table->text('when_to_use')->nullable()->after('problem_solved');
            $table->text('when_not_to_use')->nullable()->after('when_to_use');
            $table->text('data_required')->nullable()->after('when_not_to_use');
            $table->text('outcome')->nullable()->after('data_required');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tools', function (Blueprint $table) {
            $table->dropColumn(['problem_solved', 'when_to_use', 'when_not_to_use', 'data_required', 'outcome']);
        });
    }
};
