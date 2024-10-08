<?php

namespace App\Repositories;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use PDO;

class UserRepository extends Repository
{
    private const int REGENERATION_INTERVAL = 300;  // seconds

    public function getByEmail(string $email): ?object
    {
        $sql = <<<SQL
            SELECT id, password, pass_salt AS salt
            FROM users
            WHERE email = :email
        SQL;

        $user = $this->db
            ->execute($sql, ['email' => $email])
            ->fetch(PDO::FETCH_OBJ);

        return $user ? $user : null;
    }

    public function create(string $name, string $email, string $password): int
    {
        $salt = base64_encode(random_bytes(6));

        $sql = <<<SQL
            INSERT INTO users (name, password, gender, born, email, staffnotes, voted,
                               user_notepad, pass_salt, display_pic)
            VALUES (:name, :password, :gender, :born, :email, :staffnotes, :voted,
                    :user_notepad, :pass_salt, :display_pic)
        SQL;
        $this->db->execute($sql, [
            'name' => $name,
            'password' => md5($salt . md5($password)),
            'gender' => ['Male', 'Female'][mt_rand(0, 1)],
            'born' => CarbonImmutable::now()->format('Y-m-d H:i:s'),
            'email' => $email,
            'staffnotes' => '',
            'voted' => '',
            'user_notepad' => '',
            'pass_salt' => $salt,
            'display_pic' => '',
        ]);

        return $this->db->lastInsertId();
    }

    public function list(int $page = 1, int $limit = 15): array
    {
        $records = $this->db->execute('SELECT COUNT(*) FROM users')->fetch(PDO::FETCH_COLUMN);
        $pages = ceil($records / $limit);
        $page = max(1, min($page, $pages));
        $sql = <<<SQL
            SELECT u.name,
                   IF(u.jail > 0, 'Jail', IF(u.hospital > 0, 'Hospital', c.name)) AS location,
                   MAX(s.last_seen) AS last_seen
            FROM seen s
            LEFT JOIN users u ON u.id = s.user_id
            LEFT JOIN cities c ON c.id = u.city_id
            GROUP BY u.id
            ORDER BY last_seen DESC
            LIMIT :offset, :limit
        SQL;
        return $this->db->execute($sql, [
            'offset' => ($page - 1) * $limit,
            'limit' => $limit,
        ])->fetchAll(PDO::FETCH_OBJ);
    }

    public function numInmates(): int
    {
        return $this->db
            ->execute('SELECT COUNT(*) FROM users WHERE jail > :now', ['now' => time()])
            ->fetch(PDO::FETCH_COLUMN);
    }

    public function numPatients(): int
    {
        return $this->db
            ->execute('SELECT COUNT(*) FROM users WHERE hospital > :now', ['now' => time()])
            ->fetch(PDO::FETCH_COLUMN);
    }

    public function deposit(int $uid, int $amount): void
    {
        $sql = <<<SQL
            UPDATE users
            SET cash = cash - :amount1, bank = bank + :amount2
            WHERE id = :uid AND cash >= :amount3
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
            SET bank = bank - :amount1, cash = cash + :amount2
            WHERE id = :uid AND bank >= :amount3
        SQL;

        $this->db->execute($sql, [
            'amount1' => $amount,
            'amount2' => $amount,
            'amount3' => $amount,
            'uid' => $uid,
        ]);
    }

    public function regenerate(int $uid): void
    {
        $sql = <<<SQL
            SELECT u.energy, u.maxenergy, u.nerve, u.maxnerve, u.health, u.maxhealth, u.power, h.power AS maxwill,
                   u.regenerated, COALESCE(u.premium, '2000-01-01 00:00:00') AS premium
            FROM users u
            LEFT JOIN houses h ON u.house_id = h.id
            WHERE u.id = :uid
        SQL;
        $data = $this->db->execute($sql, ['uid' => $uid])->fetch(PDO::FETCH_OBJ);

        $regenerated = CarbonImmutable::parse($data->regenerated);
        $now = CarbonImmutable::now();
        $seconds = $regenerated->diffInSeconds($now);
        $premium = CarbonImmutable::parse($data->premium) > CarbonImmutable::now();

        if ($seconds < self::REGENERATION_INTERVAL) {
            return;     // Don't update IF the interval is less than 5 minutes
        }

        // energy refills at  1 every 5 minutes (1.5 for donators)
        // nerve  refills at  1 every 5 minutes
        // health refills at 20 every 3 minutes
        // power  refills at 10 every 5 minutes

        $sql = <<<SQL
            UPDATE users
            SET energy = LEAST(maxenergy, energy + (:increment * :seconds1) / :interval1),
                nerve = LEAST(maxnerve, nerve + (1 * :seconds2) / :interval2),
                health = LEAST(maxhealth, health + (100 * :seconds3) / (3 * :interval3)),
                power = LEAST(:maxpower, power + (10 * :seconds4) / :interval4),
                regenerated = :now
            WHERE id = :uid
        SQL;
        $this->db->execute($sql, [
            'increment' => $premium ? 1.5 : 1,
            'seconds1' => $seconds,
            'seconds2' => $seconds,
            'seconds3' => $seconds,
            'seconds4' => $seconds,
            'interval1' => self::REGENERATION_INTERVAL,
            'interval2' => self::REGENERATION_INTERVAL,
            'interval3' => self::REGENERATION_INTERVAL,
            'interval4' => self::REGENERATION_INTERVAL,
            'now' => $now->format('Y-m-d H:i:s'),
            'uid' => $uid,
            'maxpower' => $data->maxpower,
        ]);
    }

    public function travel(int $uid, int $city_id, int $cost): bool
    {
        $sql = <<<SQL
            UPDATE users
            SET city_id = :city_id, cash = cash - :cost
            WHERE cash >= :price AND id = :uid
        SQL;
        $statement = $this->db->execute($sql, [
            'city_id' => $city_id,
            'cost' => $cost,
            'price' => $cost,
            'uid' => $uid
        ]);

        return $statement->rowCount() > 0;
    }

    public function get(int $id): ?object
    {
        $sql = <<<SQL
            SELECT u.born, u.cash, u.bank, u.id, u.diamonds, u.guard AS defense, u.labour AS endurance,
                   u.IQ AS intelligence, u.energy, u.maxenergy, u.nerve, u.maxnerve, u.health, u.maxhealth,
                   u.power, h.power AS maxpower, u.name, u.city_id, u.level, u.exp AS experience,
                   u.strength, u.agility, u.guard AS defense, u.IQ AS intelligence, u.labour AS endurance, u.gender
            FROM users u
            LEFT JOIN houses h ON h.id = u.house_id
            WHERE u.id = :userId
        SQL;

        return $this->objectOrNull($this->db->execute($sql, ['userId' => $id])->fetch(PDO::FETCH_OBJ));
    }

    public function getExtended(int $uid): object
    {
        $sql = <<<SQL
            SELECT u.born, u.cash, u.bank, u.id, u.diamonds, u.guard AS defense, u.labour AS endurance,
                   u.IQ AS intelligence, u.energy, u.maxenergy, u.nerve, u.maxnerve, u.health, u.maxhealth,
                   u.power, h.power AS maxpower, u.name, u.city_id, u.level, u.exp AS experience,
                   u.strength, u.agility, u.guard AS defense, u.IQ AS intelligence, u.labour AS endurance, u.gender,
                   h.name AS house_name, c.name AS city_name
            FROM users u
            LEFT JOIN cities c ON c.id = u.city_id
            LEFT JOIN houses h ON h.id = u.house_id
            WHERE u.id = :uid
        SQL;

        return $this->db->execute($sql, ['uid' => $uid])->fetch(PDO::FETCH_OBJ);
    }

    public function getPaginatedList(int $page, int $ipp = 10): object
    {
        $records = $this->db->execute('SELECT COUNT(*) FROM users')->fetch(PDO::FETCH_COLUMN);
        $pages = (int) ceil($records / $ipp);
        $page = max(1, min($page, $pages));
        $offset = ($page - 1) * $ipp;
        $sql = <<<SQL
            SELECT u.id, u.name, c.name AS city, MAX(s.last_seen) AS last_seen
            FROM seen s             
            LEFT JOIN users u ON u.id = s.user_id     
            LEFT JOIN cities c ON c.id = u.city_id        
            GROUP BY u.id             
            ORDER BY last_seen DESC
            LIMIT :offset, :ipp
        SQL;
        $items = $this->db
            ->execute($sql, ['offset' => $offset, 'ipp' => $ipp])
            ->fetchAll(PDO::FETCH_UNIQUE);

        return (object)[
            'records' => $records,
            'pages' => $this->paginationButtons($page, $pages),
            'page' => $page,
            'ipp' => $ipp,
            'items' => $this->arrayOfObjects($items),
        ];
    }

    public function delete(int $id): void
    {
        $this->db->execute('DELETE FROM users WHERE id = :id', ['id' => $id]);
    }
}
