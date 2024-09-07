<?php

namespace App\Controllers;

use App\Classes\View;
use App\Repositories\PlayerRepository;
use DI\Attribute\Inject;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ExploreController extends Controller
{
    #[Inject]
    private PlayerRepository $playerRepository;

    public function __invoke(Request $request, Response $response): Response
    {
        $uid = $request->getAttribute('uid');
        $user = $this->playerRepository->getExtended($uid);

        return $this->view('explore.twig', ['user' => $user]);
    }
}
