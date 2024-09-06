<?php

namespace App\Controllers;

use App\Repositories\UserRepository;
use DI\Attribute\Inject;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ExploreController extends Controller
{
    #[Inject]
    private UserRepository $userRepository;

    public function __invoke(Request $request, Response $response): Response
    {
        $uid = $request->getAttribute('uid');

        $user = $this->userRepository->getExtended($uid);

        return $this->view('explore.twig', ['user' => $user]);
    }
}
