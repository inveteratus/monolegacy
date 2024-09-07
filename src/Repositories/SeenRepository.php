<?php

namespace App\Repositories;

use Carbon\CarbonImmutable;

class SeenRepository extends Repository
{
    public function track(int $userId): void
    {
        $now = new CarbonImmutable();
        $last_seen = $now->format('Y-m-d H:i:s');
        $sql = <<<SQL
            INSERT INTO `seen` (`user_id`, `date`, `hour`, `hits`, `last_seen`)
            VALUES (:user_id, :date, :hour, 1, :last_seen1)
            ON DUPLICATE KEY UPDATE `hits` = `hits` + 1, `last_seen` = :last_seen2
        SQL;

        $this->db->execute($sql, [
            'user_id' => $userId,
            'date' => $now->format('Y-m-d'),
            'hour' => $now->hour,
            'last_seen1' => $last_seen,
            'last_seen2' => $last_seen,
        ]);
    }
}
