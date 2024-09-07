<?php

use App\Controllers\BankController;
use App\Controllers\ExploreController;
use App\Controllers\PlayerListController;
use App\Controllers\StaffController;
use App\Controllers\TravelAgentController;
use App\Controllers\UniversityController;
use App\Middleware\AuthMiddleware;
use App\Middleware\SessionMiddleware;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface;

return function (App $app) {
    $ci = $app->getContainer();

    $app->group('', function (RouteCollectorProxyInterface $app) {

        $app->get('/explore', ExploreController::class)->setName('explore');
        $app->get('/players', PlayerListController::class)->setName('players');
        $app->get('/staff', StaffController::class)->setName('staff');

        $app->get('/bank', [BankController::class, 'get'])->setName('bank');
        $app->post('/bank', [BankController::class, 'post']);

        $app->get('/travel', [TravelAgentController::class, 'get'])->setName('travel');
        $app->post('/travel', [TravelAgentController::class, 'post']);

        $app->get('/university', [UniversityController::class, 'get'])->setName('university');
        $app->get('/university/{course}', [UniversityController::class, 'viewCourse'])->setName('university.course');

    })
        ->add($ci->get(AuthMiddleware::class))
        ->add($ci->get(SessionMiddleware::class));
};
