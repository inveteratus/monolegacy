<?php

use App\Controllers\LoginController;
use App\Controllers\RegisterController;
use App\Middleware\GuestMiddleware;
use App\Middleware\SessionMiddleware;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface;

return new class
{
    public function __invoke(App $app): void
    {
        $app->group('', function (RouteCollectorProxyInterface $app) {
            $app->group('', function (RouteCollectorProxyInterface $app) {

                $app->get('/login', [LoginController::class, 'get'])
                    ->setName('login');
                $app->post('/login', [LoginController::class, 'post']);

                $app->get('/register', [RegisterController::class, 'get'])
                    ->setName('register');
                $app->post('/register', [RegisterController::class, 'post']);

            })->add(new GuestMiddleware());
        })->add(new SessionMiddleware());
    }
};
