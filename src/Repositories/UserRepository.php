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

        $id = $this->db->lastInsertId();

        $sql = <<<SQL
            INSERT INTO userstats (userid, strength, agility, guard, labour, IQ)
            VALUE (:userid, :strength, :agility, :guard, :labour, :IQ)
        SQL;
        $this->db->execute($sql, [
            'userid' => $id,
            'strength' => 10,
            'agility' => 10,
            'guard' => 10,
            'labour' => 10,
            'IQ' => 10,
        ]);

        return $id;
    }
}
