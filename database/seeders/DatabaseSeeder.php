<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\File;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create a user to associate files with
        $user = User::factory()->create([
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test@example.com',
           
            'password' => bcrypt('password'),
        ]);

        // Create 100 fake files for that user
        File::factory(100)->create([
            'user_id' => $user->id,
        ]);
    }
}
