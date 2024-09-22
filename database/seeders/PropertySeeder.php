<?php

namespace Database\Seeders;

use App\Models\Property;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;


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
                'image' => $this->makeImage(resource_path('assets/houses/cottage.png')),
                'cost' => 250000,
                'capacity' => 100,
            ],
            [
                'name' => 'Bungalow',
                'slug' => 'bungalow',
                'description' => 'A one-story house with a rectangular shape and a sloping roof. Often features a front porch and a small garden.',
                'image' => $this->makeImage(resource_path('assets/houses/bungalow.png')),
                'cost' => 400000,
                'capacity' => 150,
            ],
            [
                'name' => 'Ranch',
                'slug' => 'ranch',
                'description' => 'A single-story home with an L-shaped or U-shaped floor plan, often featuring large windows and sliding glass doors leading to the outdoors.',
                'image' => $this->makeImage(resource_path('assets/houses/ranch.png')),
                'cost' => 600000,
                'capacity' => 200,
            ],
            [
                'name' => 'Chalet',
                'slug' => 'chalet',
                'description' => 'A small, rustic house with a sloping roof and often features a fireplace and wooden beams.',
                'image' => $this->makeImage(resource_path('assets/houses/chalet.png')),
                'cost' => 800000,
                'capacity' => 300,
            ],
            [
                'name' => 'Villa',
                'slug' => 'Villa',
                'description' => 'A luxurious home with a Mediterranean or Italian design, featuring arches, columns, and ornate details.',
                'image' => $this->makeImage(resource_path('assets/houses/villa.png')),
                'cost' => 1100000,
                'capacity' => 400,
            ],
            [
                'name' => 'Townhouse',
                'slug' => 'townhouse',
                'description' => 'A multi-story house that shares one or more walls with neighboring houses, often features a courtyard or patio.',
                'image' => $this->makeImage(resource_path('assets/houses/townhouse.png')),
                'cost' => 1500000,
                'capacity' => 600,
            ],
            [
                'name' => 'Condominium',
                'slug' => 'condominium',
                'description' => 'An apartment-style home owned by an individual but shared common areas with other owners.',
                'image' => $this->makeImage(resource_path('assets/houses/condominium.png')),
                'cost' => 2000000,
                'capacity' => 850,
            ],
            [
                'name' => 'Apartment',
                'slug' => 'apartment',
                'description' => 'A multi-unit dwelling where each unit is a separate living space, often featuring shared hallways and amenities like a gym or pool.',
                'image' => $this->makeImage(resource_path('assets/houses/apartment.png')),
                'cost' => 2700000,
                'capacity' => 1200,
            ],
            [
                'name' => 'Penthouse',
                'slug' => 'penthouse',
                'description' => 'An apartment-style home located on the top floor of a high-rise building, often features large windows, luxurious finishes, and panoramic views.',
                'image' => $this->makeImage(resource_path('assets/houses/penthouse.png')),
                'cost' => 3600000,
                'capacity' => 1700,
            ],
            [
                'name' => 'Mansion',
                'slug' => 'mansion',
                'description' => 'A large, luxurious estate with multiple bedrooms, bathrooms, and amenities like pools, tennis courts, and more.',
                'image' => $this->makeImage(resource_path('assets/houses/mansion.png')),
                'cost' => 4800000,
                'capacity' => 2450,
            ],
            [
                'name' => 'Castle',
                'slug' => 'castle',
                'description' => 'A grand, fortified dwelling that resembles a medieval castle, often features stone walls, towers, and opulent details.',
                'image' => $this->makeImage(resource_path('assets/houses/castle.png')),
                'cost' => 6400000,
                'capacity' => 3500,
            ],
            [
                'name' => 'Palace',
                'slug' => 'palace',
                'description' => 'An opulent, luxurious estate with a grand scale, often features multiple stories, lavish decor, and extensive grounds.',
                'image' => $this->makeImage(resource_path('assets/houses/palace.png')),
                'cost' => 8600000,
                'capacity' => 5000,
            ],
        ];

        foreach ($properties as $property) {
            Property::factory()->create($property);
        }
    }

    private function makeImage(string $filename): ?string
    {
        if (str_ends_with($filename, '.png')) {
            $input = imagecreatefrompng($filename);
        }
        elseif (str_ends_with($filename, '.jpg') || str_ends_with($filename, '.jpeg')) {
            $input = imagecreatefromjpeg($filename);
        }
        else {
            return null;
        }

        $sx = imagesx($input);
        $sy = imagesy($input);
        if (($sx < 800) || ($sy < 600)) {
            imagedestroy($input);
            return null;
        }

        // scale to fit within 800x600
        $scale = max($sx / 800, $sy / 600);
        $dx = floor($sx / $scale);
        $dy = floor($sy / $scale);

        $output = imagecreatetruecolor($dx, $dy);
        imagecopyresampled($output, $input, 0, 0, 0, 0, $dx, $dy, $sx, $sy);
        ob_start();
        imagejpeg($output);
        $buffer = ob_get_clean();
        imagedestroy($output);
        imagedestroy($input);

        $target = 'houses/' . sha1(random_bytes(256)) . '.jpeg';
        Storage::disk('public')->put($target, $buffer);

        return $target;
    }
}
