<?php

namespace Monolegacy\Repositories;

use Monolegacy\Classes\Database;

abstract class Repository
{
    public function __construct(protected Database $db)
    {
    }
}
