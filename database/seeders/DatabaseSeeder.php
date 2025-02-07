<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(100)->create();

        Category::factory(10)->create()->each(function ($category) {
            Product::factory(10)->create([
                'category_id' => $category->id,
            ]);
        });
    }
}
