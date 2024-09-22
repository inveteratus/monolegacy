<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Property;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),

            'cash' => 100,
            'bank' => 0,
            'tokens' => 0,
            'premium' => null,

            'energy' => 100,
            'nerve' => 10,
            'health' => 100,
            'power' => 100,

            'max_energy' => 100,
            'max_nerve' => 10,
            'max_health' => 100,

            'regenerated_at' => now()->toImmutable(),

            'strength' => 0,
            'agility' => 0,
            'defense' => 0,
            'intelligence' => 0,
            'endurance' => 0,

            'city_id' => City::factory(),
            'property_id' => Property::factory(),

            'jail' => CarbonImmutable::parse('2000-01-01 00:00:00'),
            'hospital' => CarbonImmutable::parse('2000-01-01 00:00:00'),
            'reason' => null,
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
