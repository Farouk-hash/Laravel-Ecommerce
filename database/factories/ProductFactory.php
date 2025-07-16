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
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'=>$this->faker->unique()->words(3,true),
            'description'=>$this->faker->paragraph(3),
            'quantity'=>$this->faker->numberBetween(1,300),
            'price' => $this->faker->randomFloat(2, 5, 500),
            'image_path'=>$this->faker->imageUrl() ,
            'file_object_key'=>$this->faker->filePath(),
            'category_id'=>Category::inRandomOrder()->first()->id ?? Category::factory(),
        ];
    }
}
