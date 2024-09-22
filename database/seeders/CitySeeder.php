<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        Storage::disk('public')->deleteDirectory('cities');

        $cities = [
            [
                'name' => 'London',
                'slug' => 'london',
                'description' => <<<TEXT
                    London is the capital and largest city of both England and the United Kingdom, with a population of
                    8,866,180 in 2022. The wider metropolitan area is the largest in Western Europe, with a population
                    of 14.9 million. London stands on the River Thames in southeast England, at the head of a 50-mile
                    estuary down to the North Sea, and has been a major settlement for nearly 2,000 years.
                TEXT,
                'image' => $this->makeImage(resource_path('assets/cities/london.png')),
                'latitude' => 51.5074,
                'longitude' => -0.1278,
                'min_level' => 1,
            ],
            [
                'name' => 'Paris',
                'slug' => 'paris',
                'description' => <<<TEXT
                    Paris is the capital and largest city of France. With an official estimated population of
                    2,102,650 residents in January 2023 in and area of more than 105km², Paris is the fourth-largest
                    city in the European Union and the 30th most densely populated city in the work in 2022. Since the
                    17th century, Paris has been one of the world's major centers of finance, diplomacy, commerce,
                    culture, fashion, and gastronomy.
                TEXT,
                'image' => $this->makeImage(resource_path('assets/cities/paris.png')),
                'latitude' => 48.8575,
                'longitude' => 2.3514,
                'min_level' => 2,
            ],
            [
                'name' => 'New York City',
                'slug' => 'new-york-city',
                'description' => <<<TEXT
                    New York, often called New York City or NYC, is the most populous city in the United States,
                    located at the southern tip of New York State on one of the world's largest natural harbors. The
                    city comprises five boroughs, each coextensive with a respective county. New York is a global
                    center of finance and commerce, culture, technology, entertainment and media, academics and
                    scientific output, the arts and fashion, and, as home to the headquarters of the United Nations,
                    international diplomacy.
                TEXT,
                'image' => $this->makeImage(resource_path('assets/cities/new-york.png')),
                'latitude' => 40.7128,
                'longitude' => -74.006,
                'min_level' => 3,
            ],
            [
                'name' => 'Sydney',
                'slug' => 'sydney',
                'description' => <<<TEXT
                    Sydney is the capital city of the state of New South Wales and the most populous city in Australia.
                    Located on Australia's east coast, the metropolis surrounds Sydney Harbour and extends about 80 km
                    from the Pacific Ocean in the east to the Blue Mountains in the west, and about 80 km from the
                    Ku-ring-gai Chase National Park and the Hawkesbury River in the north and north-west, to the Royal
                    National Park and Macarthur in the south and south-west.
                TEXT,
                'image' => $this->makeImage(resource_path('assets/cities/sydney.png')),
                'latitude' => -33.8688,
                'longitude' => 151.2093,
                'min_level' => 5,
            ],
            [
                'name' => 'Rio de Janeiro',
                'slug' => 'rio-de-janeiro',
                'description' => <<<TEXT
                    Rio de Janeiro or simply Rio, is the capital of the state of Rio de Janeiro. It is the
                    second-most-populous city in Brazil (after São Paulo) and the sixth-most-populous city in the
                    Americas. Founded in 1565 by the Portuguese, the city was initially the seat of the Captaincy of
                    Rio de Janeiro, a domain of the Portuguese Empire.
                TEXT,
                'image' => $this->makeImage(resource_path('assets/cities/rio-de-janeiro.png')),
                'latitude' => -22.9068,
                'longitude' => -43.1729,
                'min_level' => 8,
            ],
            [
                'name' => 'Rome',
                'slug' => 'rome',
                'description' => <<<TEXT
                    The Metropolitan City of Rome, with a population of 4,355,725 residents, is the most populous
                    metropolitan city in Italy. Its metropolitan area is the third-most populous within Italy. Rome is
                    located in the central-western portion of the Italian Peninsula, within Lazio, along the shores of
                    the Tiber.
                TEXT,
                'image' => $this->makeImage(resource_path('assets/cities/rome.png')),
                'latitude' => 41.8967,
                'longitude' => 12.4822,
                'min_level' => 13,
            ],
            [
                'name' => 'Athens',
                'slug' => 'athens',
                'description' => <<<TEXT
                    Athens is the capital and largest city of Greece. A major coastal urban area in the Mediterranean,
                    Athens is also the capital of the Attica region and is the southernmost capital on the European
                    mainland. With its urban area's population numbering over three and a quarter million, it is the
                    eighth largest urban area in the European Union. The Municipality of Athens (also City of Athens),
                    which constitutes a small administrative unit of the entire urban area, had a population of 643,452
                    (2021) within its official limits, and a land area of 38.96²km.
                TEXT,
                'image' => $this->makeImage(resource_path('assets/cities/athens.png')),
                'latitude' => 37.9838,
                'longitude' => 23.7275,
                'min_level' => 21,
            ],
            [
                'name' => 'San Francisco',
                'slug' => 'san-francisco',
                'description' => <<<TEXT
                    San Francisco, officially the City and County of San Francisco, is the commercial, financial, and
                    cultural center of Northern California. With a population of 808,988 residents as of 2023, San
                    Francisco is the fourth most populous city in the U.S. state of California behind Los Angeles, San
                    Diego, and San Jose.
                TEXT,
                'image' => $this->makeImage(resource_path('assets/cities/san-francisco.png')),
                'latitude' => 37.7749,
                'longitude' => -122.4194,
                'min_level' => 34,
            ],
            [
                'name' => 'Moscow',
                'slug' => 'moscow',
                'description' => <<<TEXT
                    Moscow, on the Moskva River in western Russia, is the nation’s cosmopolitan capital. In its
                    historic core is the Kremlin, a complex that’s home to the president and tsarist treasures in the
                    Armoury. Outside its walls is Red Square, Russia's symbolic center. It's home to Lenin’s Mausoleum,
                    the State Historical Museum's comprehensive collection and St. Basil’s Cathedral, known for its
                    colorful, onion-shaped domes.
                TEXT,
                'image' => $this->makeImage(resource_path('assets/cities/moscow.png')),
                'latitude' => 55.7558,
                'longitude' => 37.6173,
                'min_level' => 55,
            ],
            [
                'name' => 'Beijing',
                'slug' => 'beijing',
                'description' => <<<TEXT
                    Beijing, China’s sprawling capital, has history stretching back 3 millennia. Yet it’s known as much
                    for modern architecture as its ancient sites such as the grand Forbidden City complex, the imperial
                    palace during the Ming and Qing dynasties. Nearby, the massive Tiananmen Square pedestrian plaza is
                    the site of Mao Zedong’s mausoleum and the National Museum of China, displaying a vast collection
                    of cultural relics.
                TEXT,
                'image' => $this->makeImage(resource_path('assets/cities/beijing.png')),
                'latitude' => 39.9042,
                'longitude' => 116.4074,
                'min_level' => 89,
            ],
        ];

        foreach ($cities as $city) {
            City::factory()->create($city);
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

        $target = 'cities/' . sha1(random_bytes(256)) . '.jpeg';
        Storage::disk('public')->put($target, $buffer);

        return $target;
    }
}
