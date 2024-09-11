<?php

use App\Controllers\BankController;
use App\Controllers\ExploreController;
use App\Controllers\HomeController;
use App\Controllers\PlayersController;
use App\Controllers\StaffController;
use App\Controllers\TravelController;
use App\Controllers\UniversityController;
use App\Middleware\AuthMiddleware;
use App\Middleware\SeenMiddleware;
use App\Middleware\SessionMiddleware;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface;

return function (App $app) {
    $ci = $app->getContainer();

    $app->group('', function (RouteCollectorProxyInterface $app) {

        $app->get('/home', HomeController::class)->setName('home');
        $app->get('/explore', ExploreController::class)->setName('explore');
        $app->get('/players', PlayersController::class)->setName('players');
        $app->get('/staff', StaffController::class)->setName('staff');

        $app->get('/bank', BankController::class)->setName('bank');
        $app->post('/bank', [BankController::class, 'transfer']);

        $app->get('/travel', TravelController::class)->setName('travel');
        $app->post('/travel', [TravelController::class, 'post']);

        $app->get('/university', [UniversityController::class, 'get'])->setName('university');
        $app->get('/university/{course}', [UniversityController::class, 'viewCourse'])->setName('university.course');
    })
        ->add($ci->get(SeenMiddleware::class))
        ->add($ci->get(AuthMiddleware::class))
        ->add($ci->get(SessionMiddleware::class));
};
