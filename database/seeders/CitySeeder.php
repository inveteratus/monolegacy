<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            [
                'name' => 'London',
                'slug' => 'london',
                'description' => 'London is the capital of the United Kingdom and one of the world’s most influential cities. It is a major financial center, renowned for its history, architecture, and cultural landmarks such as the British Museum and the Tower of London.',
                'image' => null,
                'latitude' => 51.5074,
                'longitude' => -0.1278,
                'min_level' => 1,
            ],
            [
                'name' => 'Istanbul',
                'slug' => 'istanbul',
                'description' => 'Istanbul is a transcontinental city, straddling Europe and Asia. Historically known as Byzantium and later Constantinople, it has a rich cultural history and is one of the world’s most important historical cities, blending both eastern and western influences.',
                'image' => null,
                'latitude' => 41.0082,
                'longitude' => 28.9784,
                'min_level' => 2,
            ],
            [
                'name' => 'Cairo',
                'slug' => 'cairo',
                'description' => 'Cairo, the capital of Egypt, is the largest city in Africa and the Middle East. Famous for its proximity to the Pyramids of Giza, Cairo is a historical city with a rich Islamic heritage and a bustling, dense urban environment.',
                'image' => null,
                'latitude' => 30.0444,
                'longitude' => 31.2357,
                'min_level' => 3,
            ],
            [
                'name' => 'Kinshasa',
                'slug' => 'kinshasa',
                'description' => 'Kinshasa is the capital and largest city of the Democratic Republic of the Congo. Located on the Congo River, it’s a rapidly growing city with a youthful population, and it serves as a major cultural and economic hub in Central Africa.',
                'image' => null,
                'latitude' => -4.4419,
                'longitude' => 15.2663,
                'min_level' => 6,
            ],
            [
                'name' => 'Lagos',
                'slug' => 'lagos',
                'description' => 'Lagos is the largest city in Nigeria and Africa’s most populous urban center. Known for its rapid urbanization, it’s a major financial hub for Africa, with a vibrant music and entertainment industry, and one of the fastest-growing cities in the world.',
                'image' => null,
                'latitude' => 6.5244,
                'longitude' => 15.2663,
                'min_level' => 9,
            ],
            [
                'name' => 'Karachi',
                'slug' => 'karachi',
                'description' => 'Karachi is Pakistan\'s largest city and its main port. It’s the country\'s economic hub, famous for its diverse population, beaches, and vibrant commercial activity. Karachi also plays a significant role in global shipping and trade.',
                'image' => null,
                'latitude' => 24.8607,
                'longitude' => 67.0011,
                'min_level' => 14,
            ],
            [
                'name' => 'Delhi',
                'slug' => 'delhi',
                'description' => 'Delhi, the capital of India, is one of the oldest cities in the world, with a rich history dating back thousands of years. It’s a bustling metropolis known for its historical monuments, vibrant street markets, and being the political center of the country.',
                'image' => null,
                'latitude' => 28.7041,
                'longitude' => 77.1025,
                'min_level' => 19,
            ],
            [
                'name' => 'Dhaka',
                'slug' => 'dhaka',
                'description' => 'Dhaka, the capital of Bangladesh, is one of the most densely populated cities in the world. It’s a bustling, fast-growing city known for its textile industry, historical sites, and vibrant street life.',
                'image' => null,
                'latitude' => 23.8103,
                'longitude' => 90.4125,
                'min_level' => 26,
            ],
            [
                'name' => 'Jakarta',
                'slug' => 'jakarta',
                'description' => 'Jakarta is the capital of Indonesia and the largest city in Southeast Asia. It is an economic powerhouse in the region, with a mixture of modern skyscrapers and traditional neighborhoods, reflecting the country\'s diverse culture.',
                'image' => null,
                'latitude' => -6.2088,
                'longitude' => 106.8456,
                'min_level' => 33,
            ],
            [
                'name' => 'Shanghai',
                'slug' => 'shanghai',
                'description' => 'Shanghai is China’s largest city and a global financial hub. Located on the central coast, it’s renowned for its modern skyline, the historic Bund waterfront, and as a vital center of commerce and trade in East Asia.',
                'image' => null,
                'latitude' => 31.2304,
                'longitude' => 121.4737,
                'min_level' => 41,
            ],
            [
                'name' => 'Tokyo',
                'slug' => 'tokyo',
                'description' => 'Tokyo is the most populous city in the world and the capital of Japan. It’s a global financial hub known for its mix of ultramodern skyscrapers and historic temples. The Tokyo metropolitan area spans a vast urban sprawl, integrating several smaller cities.',
                'image' => null,
                'latitude' => 35.6762,
                'longitude' => 139.6503,
                'min_level' => 51,
            ],
            [
                'name' => 'Mexico City',
                'slug' => 'mexico-city',
                'description' => 'Mexico City, the capital of Mexico, is one of the oldest cities in the Americas. It’s a vibrant cultural and political center known for its Aztec heritage, colonial architecture, and status as one of the most important economic hubs in Latin America.',
                'image' => null,
                'latitude' => 19.4326,
                'longitude' => -99.1332,
                'min_level' => 62,
            ],
            [
                'name' => 'New York City',
                'slug' => 'new-york-city',
                'description' => 'New York City is the largest city in the United States and a global center for finance, media, and culture. Known for landmarks like Times Square, the Statue of Liberty, and Central Park, it is also one of the world’s most diverse cities.',
                'image' => null,
                'latitude' => 40.7128,
                'longitude' => -74.006,
                'min_level' => 73,
            ],
            [
                'name' => 'São Paulo',
                'slug' => 'sao-paulo',
                'description' => 'São Paulo is the largest city in Brazil and the Southern Hemisphere. Known for its cultural diversity and economic influence, it’s a key financial center in Latin America with a vibrant arts scene and vast urban landscape.',
                'image' => null,
                'latitude' => -23.5505,
                'longitude' => -46.6333,
                'min_level' => 86,
            ],
            [
                'name' => 'Buenos Aires',
                'slug' => 'buenos-aires',
                'description' => 'Buenos Aires, the capital of Argentina, is the largest city in the country and one of the most important cultural hubs in South America. Known for its European-style architecture, tango music, and vibrant arts scene, it’s also a key financial center in the region.',
                'image' => null,
                'latitude' => -34.6037,
                'longitude' => -58.3816,
                'min_level' => 100,
            ],
        ];

        foreach ($cities as $city) {
            City::factory()->create($city);
        }
    }
}
