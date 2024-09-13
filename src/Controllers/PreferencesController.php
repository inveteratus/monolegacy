<?php

namespace App\Controllers;

use App\Classes\View;
use App\Repositories\UserRepository;
use DI\Attribute\Inject;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Request;
use Slim\Routing\RouteContext;

class PreferencesController
{
    #[Inject]
    protected UserRepository $userRepository;

    #[Inject]
    protected View $view;

    public function __invoke(Request $request): ResponseInterface
    {
        $user = $this->userRepository->get($request->getAttribute('uid'));

        return $this->view->render('preferences.twig', [
            'user' => $user,
        ]);
    }

    public function save(Request $request): ResponseInterface
    {
        $routeParser = RouteContext::fromRequest($request)->getRouteParser();

        // ...

        return redirect($routeParser->urlFor('preferences'));
    }
}
