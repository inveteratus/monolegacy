<?php

namespace App\Repositories;

use App\Classes\Database;

abstract class Repository
{
    public function __construct(protected Database $db)
    { }

    public function arrayOfObjects(array $items): array
    {
        return array_map(fn ($item) => (object) $item, $items);
    }

    public function objectOrNull(object|false $object): ?object
    {
        return $object ? $object : null;
    }

    public function paginationButtons(int $page, int $pages): array
    {
        $buttons = [1, 2, $page - 2, $page - 1, $page, $page + 1, $page + 2, $pages - 1, $pages];
        $buttons = array_filter(array_unique($buttons), fn ($p) => $p >= 1 && $p <= $pages);
        sort($buttons);

        return $buttons;
    }
}
