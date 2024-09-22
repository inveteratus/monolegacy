<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Inveteratus',
            'email' => 'alan.mcfarlane@gmail.com',
            'password' => '$2y$12$iKArwT3wXSBcH0PK/m2sjuaQxzzHexK2u3pUKfkOv.Z9PqfB.NbuS',

            'city_id' => 1,
            'property_id' => 1,
        ]);
    }
}
