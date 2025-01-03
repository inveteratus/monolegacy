<?php

namespace Monolegacy\Controllers;

use DI\Attribute\Inject;
use Monolegacy\Forms\RegisterForm;
use Monolegacy\Repositories\UserRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Psr7\Factory\ResponseFactory;

class RegisterController extends Controller
{
    #[Inject]
    private RegisterForm $registerForm;
    #[Inject]
    private UserRepository $userRepository;

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        if ($request->getMethod() == 'POST') {
            if ($this->registerForm->validate($request)) {
                $_SESSION = [
                    'userid' => $this->userRepository->create(
                        $this->registerForm->name,
                        $this->registerForm->email,
                        $this->registerForm->password
                    ),
                    'loggedin' => true,
                ];

                session_regenerate_id(true);
                session_write_close();

                return (new ResponseFactory())
                    ->createResponse(302)
                    ->withHeader('Location', '/');
            }
        }

        return $this->view('register', [
            'form' => $this->registerForm,
        ]);
    }
}
