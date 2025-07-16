<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
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
            'image_path'=>$this->faker->imageUrl(),
            'file_object_key'=>$this->faker->filePath(),

        ];
    }
}
