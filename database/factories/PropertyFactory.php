<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Property>
 */
class PropertyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->word();

        return [
            'name' => $name,
            'slug' => Str::of($name)->slug(),
            'description' => fake()->text(),
            'image' => null,
            'cost' => fake()->numberBetween(100000, 10000000),
            'capacity' => fake()->numberBetween(100, 5000),
        ];
    }
}
