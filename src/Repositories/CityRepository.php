<?php

namespace App\Repositories;

use App\Classes\Database;
use PDO;

class CityRepository
{
    public function __construct(private Database $db)
    { }

    public function getAll(): array
    {
        $cities = $this->db->execute('SELECT * FROM cities')->fetchAll(PDO::FETCH_UNIQUE);

        return array_map(fn ($city) => (object) $city, $cities);
    }
}
