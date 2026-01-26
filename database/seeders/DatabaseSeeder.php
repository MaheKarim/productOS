<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::firstOrCreate(
            ['email' => 'admin@productos.bd'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('productos'),
            ]
        );

        $this->call([
            ToolSeeder::class,
            TamSamSomSeeder::class,
            DirectoryCategorySeeder::class,
            DirectoryItemSeeder::class,
            PromptCategorySeeder::class,
            PromptSeeder::class,
        ]);
    }
}
