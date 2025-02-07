<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch all users and create categories for each
        User::all()->each(function ($user) {
            // Adjust the number of categories per user as needed
            Category::factory()->count(3)->create([
                'user_id' => $user->id,
            ]);
        });
    }
}
