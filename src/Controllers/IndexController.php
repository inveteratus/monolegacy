<?php

namespace Monolegacy\Controllers;

use Monolegacy\Forms\IndexForm;
use Monolegacy\Repositories\UserRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Psr7\Factory\ResponseFactory;

class IndexController extends Controller
{
    private IndexForm $indexForm;
    #[Inject]
    private UserRepository $userRepository;

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        if ($request->getMethod() === 'POST') {
            if ($this->indexForm->validate($request)) {
                $this->userRepository->updateNotes($_SESSION['userid'], $this->indexForm->notes);

                return (new ResponseFactory())
                    ->createResponse(302)
                    ->withHeader('Location', '/');
            }
        }

        return $this->view('index', [
            'user' => $this->userRepository->get($_SESSION['userid'], true),
             'form' => $this->indexForm,
        ]);
    }
}
