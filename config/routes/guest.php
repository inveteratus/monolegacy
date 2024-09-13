<?php

use App\Controllers\IndexController;
use App\Controllers\LoginController;
use App\Controllers\RegisterController;
use App\Middleware\GuestMiddleware;
use App\Middleware\SessionMiddleware;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface;

return function (App $app) {
    $ci = $app->getContainer();

    $app->group('', function (RouteCollectorProxyInterface $app) {

        $app->get('/', IndexController::class)->setName('index');

        $app->get('/login', [LoginController::class, 'get'])->setName('login');
        $app->post('/login', [LoginController::class, 'post']);

        $app->get('/register', [RegisterController::class, 'get'])->setName('register');
        $app->post('/register', [RegisterController::class, 'post']);
    })
        ->add($ci->get(GuestMiddleware::class))
        ->add($ci->get(SessionMiddleware::class));
};
