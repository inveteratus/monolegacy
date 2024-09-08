<?php

namespace App\Controllers;

use App\Classes\View;
use App\Repositories\UserRepository;
use DI\Attribute\Inject;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class HomeController
{
    #[Inject]
    protected UserRepository $userRepository;

    #[Inject]
    protected View $view;

    public function __invoke(Request $request): Response
    {
        return $this->view->render('home.twig', [
            'user' => $this->userRepository->get($request->getAttribute('user_id'))
        ]);
    }
}
