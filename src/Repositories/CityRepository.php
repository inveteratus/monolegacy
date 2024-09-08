<?php

namespace App\Repositories;

use App\Classes\Database;
use PDO;

class CityRepository extends Repository
{
    public function getAll(): array
    {
        $cities = $this->db->execute('SELECT * FROM cities')->fetchAll(PDO::FETCH_UNIQUE);

        return array_map(fn ($city) => (object) $city, $cities);
    }

    public function get(int $id): ?object
    {
        $sql = 'SELECT * FROM cities WHERE id = :id';

        return $this->objectOrNull($this->db->execute($sql, ['id' => $id])->fetch(PDO::FETCH_OBJ));
    }
}
