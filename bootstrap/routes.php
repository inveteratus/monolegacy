<?php

use App\Controllers\BankController;
use App\Controllers\ExploreController;
use App\Controllers\LoginController;
use App\Controllers\PlayerListController;
use App\Controllers\RegisterController;
use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;
use App\Middleware\LastSeenMiddleware;
use App\Middleware\SessionMiddleware;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface;

return new class
{
    public function __invoke(App $app): void
    {
        $ci = $app->getContainer();

        $app->group('', function (RouteCollectorProxyInterface $app) use ($ci) {
            $app->group('', function (RouteCollectorProxyInterface $app) use ($ci) {

                $app->get('/login', [LoginController::class, 'get'])
                    ->setName('login');
                $app->post('/login', [LoginController::class, 'post']);

                $app->get('/register', [RegisterController::class, 'get'])
                    ->setName('register');
                $app->post('/register', [RegisterController::class, 'post']);

            })->add($ci->get(GuestMiddleware::class));

            $app->group('', function (RouteCollectorProxyInterface $app) use ($ci) {

                $app->get('/explore', ExploreController::class)
                    ->setName('explore');

                $app->get('/players', PlayerListController::class)
                    ->setName('player-list');

                $app->get('/bank', [BankController::class, 'get'])
                    ->setName('bank');
                $app->post('/bank', [BankController::class, 'post']);

            })->add($ci->get(LastSeenMiddleware::class))
              ->add($ci->get(AuthMiddleware::class));
        })->add($ci->get(SessionMiddleware::class));
    }
};
