<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'uuid' => $this->faker->uuid,
            'category_uuid' => $this->faker->randomElement(Category::all()->pluck('uuid')->toArray()),
            'title' => $this->faker->word,
            'price' => $this->faker->randomFloat(2, 0, 100),
            'description' => $this->faker->text,
            'metadata' => $this->faker->json,
        ];
    }
}