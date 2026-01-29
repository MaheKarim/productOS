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
        Schema::table('users', function (Blueprint $table) {
            // Nullable because feature might be disabled when user registers
            $table->string('job_role')->nullable()->after('email');
            $table->string('years_of_experience')->nullable()->after('job_role');
            $table->string('company_name')->nullable()->after('years_of_experience');

            // To track if they finished it. Default false to force check.
            // Existing users will need this set to true manually or via migration logic if we want to "grandfather" them.
            // But per spec: "Existing users who never completed onboarding: Will be prompted on next login". 
            // WAIT - Spec says: 
            // "Existing users who completed onboarding: No impact"
            // "Existing users who never completed onboarding: Will be prompted on next login"
            // "Handle existing users: Set onboarding_completed = true for all existing users (grandfather them in) OR prompt existing users to complete profile"
            // I will default to false, but in a separate update I might set existing users to true depending on interpretation. 
            // The prompt says "Handle existing users: Set onboarding_completed = true (grandfather them in)".
            // So I will update existing users to true in the up() method.

            $table->boolean('onboarding_completed')->default(false)->after('company_name');
            $table->timestamp('onboarding_completed_at')->nullable()->after('onboarding_completed');
        });

        // Grandfather existing users
        DB::table('users')->update(['onboarding_completed' => true]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'job_role',
                'years_of_experience',
                'company_name',
                'onboarding_completed',
                'onboarding_completed_at',
            ]);
        });
    }
};
