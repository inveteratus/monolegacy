<?php

namespace App\Controllers;

use App\Classes\View;
use App\Repositories\UserRepository;
use DI\Attribute\Inject;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class PlayersController
{
    #[Inject]
    protected UserRepository $userRepository;

    #[Inject]
    protected View $view;

    public function __invoke(Request $request): Response
    {
        $queryParams = $request->getQueryParams();
        $page = array_key_exists('page', $queryParams) && ctype_digit($queryParams['page']) ? $queryParams['page'] : 1;

        $user = $this->userRepository->get($request->getAttribute('uid'));
        $players = $this->userRepository->getPaginatedList($page);

        return $this->view->render('players.twig', [
            'players' => $players,
            'user' => $user,
        ]);
    }
}
