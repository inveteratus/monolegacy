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

    public function nameExists(string $name): bool
    {
        return $this->db
                ->execute('SELECT COUNT(*) FROM users WHERE username = :name', ['name' => $name])
                ->fetchColumn() > 0;
    }

    public function emailExists(string $email): bool
    {
        return $this->db
                ->execute('SELECT COUNT(*) FROM users WHERE email = :email', ['email' => $email])
                ->fetchColumn() > 0;
    }

    public function create(string $name, string $email, string $password): int
    {
        $sql = <<<SQL
            INSERT INTO users (username, userpass, gender, signedup, email, lastip_login, lastip_signup, last_login, pass_salt)
            VALUES (:username, :userpass, :gender, :signedup, :email, :lastip_login, :lastip_signup, :last_login, :pass_salt)
        SQL;
        $salt = substr(implode('', array_filter(str_split(random_bytes(100)), 'ctype_alnum')), -8);

        $this->db->execute($sql, [
            'username' => $name,
            'userpass' => md5($salt . md5($password)),
            'gender' => ['Male', 'Female'][random_int(0, 1)],
            'signedup' => time(),
            'email' => $email,
            'lastip_login' => $_SERVER['REMOTE_ADDR'],
            'lastip_signup' => $_SERVER['REMOTE_ADDR'],
            'last_login' => time(),
            'pass_salt' => $salt,
        ]);

        $id = $this->db->lastInsertId();
        $sql = <<<SQL
            INSERT INTO userstats (userid, strength, agility, guard, labour, IQ)
            VALUES (:id, 10, 10, 10, 10, 10)
        SQL;

        $this->db->execute($sql, ['id' => $id]);

        return $id;
    }
}
