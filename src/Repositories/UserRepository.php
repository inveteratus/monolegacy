<?php

namespace Monolegacy\Repositories;

class UserRepository extends Repository
{
    public function create(string $name, string $email, string $password): int
    {
        $sql = <<<SQL
            INSERT INTO users (username, password, gender, signedup, email, lastip_login, lastip_signup, last_login)
            VALUES (:username, :password, :gender, :signedup, :email, :lastip_login, :lastip_signup, :last_login)
        SQL;

        $this->db->execute($sql, [
            'username' => $name,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'gender' => ['Male', 'Female'][random_int(0, 1)],
            'signedup' => time(),
            'email' => $email,
            'lastip_login' => $_SERVER['REMOTE_ADDR'],
            'lastip_signup' => $_SERVER['REMOTE_ADDR'],
            'last_login' => time(),
        ]);

        $id = $this->db->lastInsertId();
        $sql = <<<SQL
            INSERT INTO userstats (userid, strength, agility, guard, labour, IQ)
            VALUES (:id, 10, 10, 10, 10, 10)
        SQL;

        $this->db->execute($sql, ['id' => $id]);
        return $id;
    }

    public function findByEmail(string $email): ?object
    {
        $sql = <<<SQL
            SELECT `userid` AS `id`, `password`
            FROM `users`
            WHERE `email` = :email
        SQL;

        $result = $this->db->execute($sql, ['email' => $email])->fetch();
        return is_object($result) ? $result : null;
    }

    public function get(int $id, bool $extended = false): ?object
    {
        if ($extended) {
            // TODO add job, gang and course

            $sql = <<<SQL
                SELECT u.userid AS id, u.username AS name, u.email, u.password, FROM_UNIXTIME(signedup) AS born,
                       u.money AS cash, u.bankmoney AS bank, u.crystals AS diamonds, u.exp AS experience, u.level,
                       u.energy, u.maxenergy AS max_energy, u.brave AS nerve, u.maxbrave AS max_nerve, u.hp AS health,
                       u.maxhp AS max_health, u.will AS power, u.maxwill AS max_power, u.hospital, u.jail,
                       u.hospreason AS reason, ELT(u.user_level + 1, 'NPC', 'Player', 'Staff') AS type, u.notes,
                       us.strength, us.agility, us.guard AS defence, us.labour AS endurance, us.IQ AS intelligence,
                       u.crimexp AS criminal, u.location AS city_id, c.cityname AS city_name, h.hID AS property_id,
                       h.hNAME AS property_name
                FROM users u
                LEFT JOIN userstats us USING (userid)
                LEFT JOIN houses h ON h.hWILL = u.maxwill
                LEFT JOIN cities c ON c.cityid = u.location
                WHERE u.userid = :id     
            SQL;
        }
        else {
            $sql = <<<SQL
                SELECT u.userid AS id, u.username AS name, u.email, u.password, FROM_UNIXTIME(signedup) AS born,
                       u.money AS cash, u.bankmoney AS bank, u.crystals AS diamonds, u.exp AS experience, u.level,
                       u.energy, u.maxenergy AS max_energy, u.brave AS nerve, u.maxbrave AS max_nerve, u.hp AS health,
                       u.maxhp AS max_health, u.will AS power, u.maxwill AS max_power, u.hospital, u.jail,
                       u.hospreason AS reason, ELT(u.user_level + 1, 'NPC', 'Player', 'Staff') AS type, u.notes,
                       us.strength, us.agility, us.guard AS defence, us.labour AS endurance, us.IQ AS intelligence,
                       u.crimexp AS criminal
                FROM users u
                LEFT JOIN userstats us USING (userid)
                WHERE u.userid = :id     
            SQL;
        }

        $result = $this->db->execute($sql, ['id' => $id])->fetch();
        return is_object($result) ? $result : null;
    }

    public function emailExists(string $email): bool
    {
        return $this->db
                ->execute('SELECT COUNT(*) FROM users WHERE email = :email', ['email' => $email])
                ->fetchColumn() > 0;
    }

    public function nameExists(string $name): bool
    {
        return $this->db
                ->execute('SELECT COUNT(*) FROM users WHERE username = :name', ['name' => $name])
                ->fetchColumn() > 0;
    }

    public function updateNotes(int $id, string $notes): void
    {
        $this->db->execute('UPDATE users SET notes = :notes WHERE userid = :id', ['id' => $id, 'notes' => $notes]);
    }
}
