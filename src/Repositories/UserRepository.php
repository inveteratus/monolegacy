<?php

namespace Monolegacy\Repositories;

use Monolegacy\Classes\Database;

class UserRepository
{
    public function __construct(private Database $db)
    {
    }

    public function findByEmail(string $email): ?object
    {
        $sql = <<<SQL
            SELECT `userid` AS `id`, CONCAT(`pass_salt`, '$', `userpass`) AS `password`
            FROM `users`
            WHERE `email` = :email
        SQL;

        $result = $this->db->execute($sql, ['email' => $email])
            ->fetch();

        return is_object($result) ? $result : null;
    }

    public function findById(int $id): ?object
    {
        $sql = <<<SQL
            SELECT u.*, us.*
            FROM users u
            LEFT JOIN userstats us USING (userid)
            WHERE u.userid = :id
        SQL;

        $result = $this->db->execute($sql, ['id' => $id])
            ->fetch();

        return is_object($result) ? $result : null;
    }
}
