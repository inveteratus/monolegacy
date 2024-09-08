<?php

namespace App\Controllers;

use App\Classes\View;
use App\Repositories\CityRepository;
use App\Repositories\UserRepository;
use DI\Attribute\Inject;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Request;

class ExploreController
{
    #[Inject]
    protected CityRepository $cityRepository;

    #[Inject]
    protected UserRepository $userRepository;

    #[Inject]
    protected View $view;

    public function __invoke(Request $request): ResponseInterface
    {
        $user = $this->userRepository->get($request->getAttribute('uid'));

        return $this->view->render('explore.twig', [
            'city' => $this->cityRepository->get($user->city_id),
            'user' => $user,
        ]);
    }
}
