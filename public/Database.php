<?php

class Database
{
    /** @deprecated */
    private string $host;
    /** @deprecated */
    private string $user;
    /** @deprecated */
    private string $pass;
    /** @deprecated */
    private string $database;
    /** @deprecated */
    private mysqli_result|bool $result;
    /** @deprecated */
    public mysqli $connection_id;

    private PDO $pdo;

    public function __construct(string $dsn, string $user, string $password)
    {
        $this->pdo = new PDO($dsn, $user, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
    }

    public function execute(string $sql, array $context): PDOStatement
    {
        $statement = $this->pdo->prepare($sql);
        $statement->execute($context);

        return $statement;
    }

    /** @deprecated */
    public function configure($host, $user, $pass, $database)
    {
        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;
        $this->database = $database;
        return 1; //Success.
    }

    /** @deprecated */
    public function connect(): mysqli
    {
        if (!$this->host)
        {
            $this->host = "localhost";
        }
        if (!$this->user)
        {
            $this->user = "root";
        }
        $conn =
                mysqli_connect($this->host, $this->user, $this->pass,
                        $this->database);
        if (mysqli_connect_error())
        {
            error_critical('Database connection failed',
                    mysqli_connect_errno() . ': ' . mysqli_connect_error(),
                    'Attempted to connect to database on ' . $this->host,
                    debug_backtrace(false));
        }
        // @overridecharset mysqli
        $this->connection_id = $conn;
        return $this->connection_id;
    }

    /** @deprecated */
    public function query(string $query): mysqli_result|bool
    {
        $this->result = mysqli_query($this->connection_id, $query);
        if ($this->result === false)
        {
            error_critical('Query failed',
                    mysqli_errno($this->connection_id) . ': '
                            . mysqli_error($this->connection_id),
                    'Attempted to execute query: ' . nl2br($query),
                    debug_backtrace(false));
        }
        return $this->result;
    }

    /** @deprecated */
    public function fetch_row(?mysqli_result $result = null): array|false|null
    {
        return mysqli_fetch_assoc($result ?? $this->result);
    }

    /** @deprecated */
    public function num_rows(?mysqli_result $result = null)
    {
        return mysqli_num_rows($result ?? $this->result);
    }

    /** @deprecated */
    public function insert_id(): int|null
    {
        return mysqli_insert_id($this->connection_id);
    }

    /** @deprecated */
    public function fetch_single(?mysqli_result $result = null)
    {
        mysqli_data_seek($result ?? $this->result, 0);

        return mysqli_fetch_array($result ?? $this->result)[0];
    }

    /** @deprecated */
    public function escape(string $text): string
    {
        return mysqli_real_escape_string($this->connection_id, $text);
    }

    /** @deprecated */
    public function affected_rows(): int
    {
        return mysqli_affected_rows($this->connection_id);
    }

    /** @deprecated */
    public function free_result(mysqli_result $result): void
    {
        mysqli_free_result($result);
    }
}
