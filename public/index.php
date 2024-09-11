<?php

use Respect\Validation\Factory;

require __DIR__ . '/../vendor/autoload.php';

Factory::setDefaultInstance(
    (new Factory())
        ->withRuleNamespace('App\\Validation\\Rules')
        ->withExceptionNamespace('App\\Validation\\Exceptions')
);

(require __DIR__ . '/../config/bootstrap.php')->run();
