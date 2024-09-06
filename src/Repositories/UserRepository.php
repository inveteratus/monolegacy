<?php

namespace App\Repositories;

use PDO;
use Psr\Http\Message\ServerRequestInterface as Request;

class UserRepository extends Repository
{
    public function getForEmail(string $email): ?object
    {
        $sql = <<<SQL
            SELECT userid AS id, userpass AS password, pass_salt AS salt
            FROM users
            WHERE email = :email
        SQL;

        $user = $this->db
            ->execute($sql, ['email' => $email])
            ->fetch(PDO::FETCH_OBJ);

        return $user ? $user : null;
    }

    public function updateLastLogin(int $uid): void
    {
        $sql = <<<SQL
            UPDATE users
            SET last_login = :now, lastip_login = :ip
            WHERE userid = :uid
        SQL;
        $this->db->execute($sql, [
            'now' => time(),
            'ip' => $_SERVER['REMOTE_ADDR'],
            'uid' => $uid,
        ]);
    }

    public function createUser(string $name, string $email, string $password): int
    {
        $salt = base64_encode(random_bytes(6));

        $sql = <<<SQL
            INSERT INTO users (username, userpass, gender, signedup, email, staffnotes, lastip_signup, voted,
                               user_notepad, pass_salt, display_pic)
            VALUES (:username, :userpass, :gender, :signedup, :email, :staffnotes, :lastip_signup, :voted,
                    :user_notepad, :pass_salt, :display_pic)
        SQL;
        $this->db->execute($sql, [
            'username' => $name,
            'userpass' => md5($salt . md5($password)),
            'gender' => ['Male', 'Female'][mt_rand(0, 1)],
            'signedup' => time(),
            'email' => $email,
            'staffnotes' => '',
            'lastip_signup' => $_SERVER['REMOTE_ADDR'],
            'voted' => '',
            'user_notepad' => '',
            'pass_salt' => $salt,
            'display_pic' => '',
        ]);

        return $this->db->lastInsertId();
    }

    public function getExtended(int $uid): object
    {
        $sql = <<<SQL
            SELECT u.*, h.hID AS house_id, h.hNAME AS house_name, c.cityid AS cityid,
                   c.cityname AS city_name
            FROM users u
            LEFT JOIN houses h ON h.hWILL = u.maxwill
            LEFT JOIN cities c ON c.cityid = u.location
            WHERE u.userid = :uid
        SQL;

        return $this->db->execute($sql, ['uid' => $uid])->fetch(PDO::FETCH_OBJ);
    }

    public function getBasic(int $uid): object
    {
        $sql = <<<SQL
            SELECT u.*
            FROM users u
            WHERE u.userid = :uid
        SQL;

        return $this->db->execute($sql, ['uid' => $uid])->fetch(PDO::FETCH_OBJ);
    }

    public function getPlayers(int $page = 1, int $limit = 15): array
    {
        $records = $this->db->execute('SELECT COUNT(*) FROM users')->fetch(PDO::FETCH_COLUMN);
        $pages = ceil($records / $limit);
        $page = max(1, min($page, $pages));
        $sql = <<<SQL
            SELECT u.username AS name,
                   IF(u.jail > 0, 'Jail', IF(u.hospital > 0, 'Hospital', c.cityname)) AS location,
                   FROM_UNIXTIME(u.laston) AS last_seen
            FROM users u
            LEFT JOIN cities c ON c.cityid = u.location
            ORDER BY u.laston DESC
            LIMIT :offset, :limit
        SQL;
        return $this->db->execute($sql, [
            'offset' => ($page - 1) * $limit,
            'limit' => $limit,
        ])->fetchAll(PDO::FETCH_OBJ);
    }

    public function updateLastSeen(int $uid): void
    {
        $sql = <<<SQL
            UPDATE users
            SET laston = :now, lastip = :ip
            WHERE userid = :uid
        SQL;
        $this->db->execute($sql, [
            'now' => time(),
            'ip' => $_SERVER['REMOTE_ADDR'],
            'uid' => $uid,
        ]);
    }

    public function inmates(): int
    {
        // TODO cache for ... 5? seconds

        return $this->db
            ->execute('SELECT COUNT(*) FROM users WHERE jail > :now', ['now' => time()])
            ->fetch(PDO::FETCH_COLUMN);
    }

    public function patients(): int
    {
        // TODO cache for ... 5? seconds

        return $this->db
            ->execute('SELECT COUNT(*) FROM users WHERE hospital > :now', ['now' => time()])
            ->fetch(PDO::FETCH_COLUMN);
    }

    public function deposit(int $uid, int $amount): void
    {
        $sql = <<<SQL
            UPDATE users
            SET money = money - :amount1, bankmoney = bankmoney + :amount2
            WHERE userid = :uid AND money >= :amount3
        SQL;

        $this->db->execute($sql, [
            'amount1' => $amount,
            'amount2' => $amount,
            'amount3' => $amount,
            'uid' => $uid,
        ]);
    }

    public function withdraw(int $uid, int $amount): void
    {
        $sql = <<<SQL
            UPDATE users
            SET bankmoney = bankmoney - :amount1, money = money + :amount2
            WHERE userid = :uid AND bankmoney >= :amount3
        SQL;

        $this->db->execute($sql, [
            'amount1' => $amount,
            'amount2' => $amount,
            'amount3' => $amount,
            'uid' => $uid,
        ]);
    }
}
