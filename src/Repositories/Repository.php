<?php

namespace App\Repositories;

use App\Classes\Database;

abstract class Repository
{
    public function __construct(protected Database $db)
    { }
}
