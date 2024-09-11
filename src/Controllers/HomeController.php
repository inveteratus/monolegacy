<?php

namespace App\Controllers;

use App\Classes\View;
use App\Repositories\UserRepository;
use DI\Attribute\Inject;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Request;

class HomeController
{
    #[Inject]
    protected UserRepository $userRepository;

    #[Inject]
    protected View $view;

    public function __invoke(Request $request): ResponseInterface
    {
        return $this->view->render('home.twig', [
            'user' => $this->userRepository->getExtended($request->getAttribute('user_id'))
        ]);
    }
}
