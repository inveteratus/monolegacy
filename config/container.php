<?php

use Psr\Container\ContainerInterface;
use Slim\App;
use Slim\Factory\AppFactory;

return [
    'settings' => fn() => (require __DIR__ . '/settings.php'),

    App::class => function (ContainerInterface $container) {
        $app = AppFactory::createFromContainer($container);

        (require __DIR__ . '/middleware.php')($app);
        (require __DIR__ . '/routes/guest.php')($app);
        (require __DIR__ . '/routes/app.php')($app);

        return $app;
    },
];
