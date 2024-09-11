<?php

use Respect\Validation\Factory;

require __DIR__ . '/../vendor/autoload.php';

// Register location of custom validation rules and extensions
Factory::setDefaultInstance(
    (new Factory())
        ->withRuleNamespace('App\\Validation\\Rules')
        ->withExceptionNamespace('App\\Validation\\Exceptions')
);

(require __DIR__ . '/../config/bootstrap.php')->run();
exit;

/*
$app = (require __DIR__ . '/../config/app.php')();

$app->addBodyParsingMiddleware();
$app->addRoutingMiddleware();

(require __DIR__ . '/../config/routes.php')($app);

$passThrough = false;
try {
    $app->run();
}
catch (HttpNotFoundException) {
    $passThrough = true;
}
*/

if (!$passThrough) {
    exit;
}

if (($_SERVER['REQUEST_URI'] !== '/') && ($_SERVER['REQUEST_URI'] !== '/index.php')) {
    die('<h1>404 Not Found</h1>');
}
