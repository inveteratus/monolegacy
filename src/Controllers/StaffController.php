<?php

namespace App\Controllers;

use App\Repositories\PlayerRepository;
use DI\Attribute\Inject;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class StaffController extends Controller
{
    #[Inject]
    private PlayerRepository $playerRepository;

    public function __invoke(Request $request): Response
    {
        $uid = $request->getAttribute('uid');
        $user = $this->playerRepository->getBasic($uid);

        return $this->view('staff.twig', [
            'user' => $user,
        ]);
    }
}
