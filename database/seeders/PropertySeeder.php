<?php

namespace Database\Seeders;

use App\Models\Property;
use Illuminate\Database\Seeder;


class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $properties = [
            [
                'name' => 'Cottage',
                'slug' => 'cottage',
                'description' => 'A small, cozy home, often with a simple design and a garden or yard.',
                'image' => null,
                'cost' => 250000,
                'capacity' => 100,
            ],
            [
                'name' => 'Bungalow',
                'slug' => 'bungalow',
                'description' => 'A one-story house with a rectangular shape and a sloping roof. Often features a front porch and a small garden.',
                'image' => null,
                'cost' => 400000,
                'capacity' => 150,
            ],
            [
                'name' => 'Ranch',
                'slug' => 'ranch',
                'description' => 'A single-story home with an L-shaped or U-shaped floor plan, often featuring large windows and sliding glass doors leading to the outdoors.',
                'image' => null,
                'cost' => 600000,
                'capacity' => 200,
            ],
            [
                'name' => 'Chalet',
                'slug' => 'chalet',
                'description' => 'A small, rustic house with a sloping roof and often features a fireplace and wooden beams.',
                'image' => null,
                'cost' => 800000,
                'capacity' => 300,
            ],
            [
                'name' => 'Villa',
                'slug' => 'Villa',
                'description' => 'A luxurious home with a Mediterranean or Italian design, featuring arches, columns, and ornate details.',
                'image' => null,
                'cost' => 1100000,
                'capacity' => 400,
            ],
            [
                'name' => 'Townhouse',
                'slug' => 'townhouse',
                'description' => 'A multi-story house that shares one or more walls with neighboring houses, often features a courtyard or patio.',
                'image' => null,
                'cost' => 1500000,
                'capacity' => 600,
            ],
            [
                'name' => 'Condominium',
                'slug' => 'condominium',
                'description' => 'An apartment-style home owned by an individual but shared common areas with other owners.',
                'image' => null,
                'cost' => 2000000,
                'capacity' => 850,
            ],
            [
                'name' => 'Apartment',
                'slug' => 'apartment',
                'description' => 'A multi-unit dwelling where each unit is a separate living space, often featuring shared hallways and amenities like a gym or pool.',
                'image' => null,
                'cost' => 2700000,
                'capacity' => 1200,
            ],
            [
                'name' => 'Penthouse',
                'slug' => 'penthouse',
                'description' => 'An apartment-style home located on the top floor of a high-rise building, often features large windows, luxurious finishes, and panoramic views.',
                'image' => null,
                'cost' => 3600000,
                'capacity' => 1700,
            ],
            [
                'name' => 'Mansion',
                'slug' => 'mansion',
                'description' => 'A large, luxurious estate with multiple bedrooms, bathrooms, and amenities like pools, tennis courts, and more.',
                'image' => null,
                'cost' => 4800000,
                'capacity' => 2450,
            ],
            [
                'name' => 'Castle',
                'slug' => 'castle',
                'description' => 'A grand, fortified dwelling that resembles a medieval castle, often features stone walls, towers, and opulent details.',
                'image' => null,
                'cost' => 6400000,
                'capacity' => 3500,
            ],
            [
                'name' => 'Palace',
                'slug' => 'palace',
                'description' => 'An opulent, luxurious estate with a grand scale, often features multiple stories, lavish decor, and extensive grounds.',
                'image' => null,
                'cost' => 8600000,
                'capacity' => 5000,
            ],
        ];

        foreach ($properties as $property) {
            Property::factory()->create($property);
        }
    }
}
