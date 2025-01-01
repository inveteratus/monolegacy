<?php

class database
{
    private PDO $pdo;
    private mysqli $mysqli;

    public function __construct(string $dsn, string $user, string $password)
    {
       $this->pdo = new PDO($dsn, $user, $password, [
           PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
           PDO::ATTR_EMULATE_PREPARES => false,
           PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
       ]);

        // Legacy (mysqli) support
        $params = array_map(
            function (string $keyValuePair): array {
                [$key, $value] = explode('=', $keyValuePair);
                return [$key => $value];
            }, explode(';', explode(':', $dsn)[1]));
        $params = array_merge(...$params);

        $result = mysqli_connect($params['host'], $user, $password, $params['dbname']);
        if (mysqli_connect_error()) {
            die('Database connection failed - ' . mysqli_connect_error());
        }

        $this->mysqli = $result;
    }

    public function execute(string $sql, array $context = []): PDOStatement
    {
        $statement = $this->pdo->prepare($sql);
        $statement->execute($context);

        return $statement;
    }

    /** @deprecated */
    public function connection(): mysqli
    {
        return $this->mysqli;
    }

    /** @deprecated */
    public function query(string $query): mysqli_result|null|true
    {
        $result = mysqli_query($this->mysqli, $query);
        if ($result === false) {
            die('query failed: ' . mysqli_error($this->mysqli));
        }

        return $result;
    }

    /** @deprecated */
    public function fetch_row(mysqli_result $result): array|false|null
    {
        return mysqli_fetch_assoc($result);
    }

    /** @deprecated */
    public function num_rows(mysqli_result $result): int|string
    {
        return mysqli_num_rows($result);
    }

    /** @deprecated */
    public function insert_id(): int|string
    {
        return mysqli_insert_id($this->mysqli);
    }

    /** @deprecated */
    public function fetch_single(mysqli_result $result)
    {
        mysqli_data_seek($result, 0);

        return mysqli_fetch_array($result)[0];
    }

    /** @deprecated */
    public function escape(string $text): string
    {
        return mysqli_real_escape_string($this->mysqli, $text);
    }

    /** @deprecated */
    public function affected_rows(): int|string
    {
        return mysqli_affected_rows($this->mysqli);
    }

    /** @deprecated */
    public function free_result($result): void
    {
    }
}
