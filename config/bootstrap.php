<?php

use App\Extensions\SlimMiddleware;
use DI\ContainerBuilder;
use Slim\App;

$container = (new ContainerBuilder())
    ->useAttributes(true)
    ->useAutowiring(true)
    ->addDefinitions(__DIR__ . '/container.php')
    ->addDefinitions(__DIR__ . '/dependencies.php')
    ->build();

$app = $container->get(App::class);
$app->add(new SlimMiddleware($app));

return $app;
