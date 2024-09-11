<?php

use Dotenv\Dotenv;
use Dotenv\Repository\Adapter\ArrayAdapter;
use Dotenv\Repository\RepositoryBuilder;

return Dotenv::create(RepositoryBuilder::createWithNoAdapters()
    ->addWriter(ArrayAdapter::class)
    ->immutable()
    ->make(), dirname(__DIR__))->load();
