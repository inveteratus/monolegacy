<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\City>
 */
class CityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->city();

        return [
            'name' => $name,
            'slug' => Str::of($name)->slug(),
            'description' => fake()->text(),
            'image' => null,
            'latitude' => fake()->latitude(),
            'longitude' => fake()->longitude(),
            'min_level' => fake()->numberBetween(1, 100),
        ];
    }
}
