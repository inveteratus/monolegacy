<?php

namespace App\Validation\Rules;

use App\Classes\Database;
use PDO;
use Respect\Validation\Rules\AbstractRule;

class RowExists extends AbstractRule
{
    public function __construct(
        private readonly Database $db,
        private readonly string $table,
        private readonly string $field,
    )
    { }

    public function validate($input): bool
    {
        $sql = <<<SQL
            SELECT COUNT(*)
            FROM {$this->table}
            WHERE {$this->field} = :input
        SQL;

        return $this->db->execute($sql, ['input' => $input])->fetch(PDO::FETCH_COLUMN) > 0;
    }
}
