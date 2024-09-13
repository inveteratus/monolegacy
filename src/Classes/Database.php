<?php

namespace App\Classes;

use PDO;
use PDOStatement;

class Database extends PDO
{
    public function __construct(string $dsn, string $user, string $password)
    {
        parent::__construct($dsn, $user, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
    }

    public function execute(string $sql, array $context = []): PDOStatement
    {
        $statement = $this->prepare($sql);
        $statement->execute($context);

        return $statement;
    }
}
