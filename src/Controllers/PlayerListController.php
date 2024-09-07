<?php

namespace App\Controllers;

use App\Repositories\PlayerRepository;
use DI\Attribute\Inject;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class PlayerListController extends Controller
{
    #[Inject]
    private PlayerRepository $userRepository;

    public function __invoke(Request $request, Response $response): Response
    {
        $uid = $request->getAttribute('uid');
        $user = $this->userRepository->getBasic($uid);
        $players = $this->userRepository->list();

        return $this->view('player-list.twig', [
            'user' => $user,
            'players' => $players,
        ]);
    }
}
