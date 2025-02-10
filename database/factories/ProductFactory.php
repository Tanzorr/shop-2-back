<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' => Category::factory(),
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'price' => $this->faker->randomFloat(2, 10, 1000), // Price between 10 and 1000
            'stock' => $this->faker->numberBetween(0, 100), // Stock between 0 and 100
            'sku' => $this->faker->unique()->bothify('SKU-#####'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}

