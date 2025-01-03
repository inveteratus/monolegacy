<?php

namespace Monolegacy\Controllers;

use DI\Attribute\Inject;
use Monolegacy\Forms\LoginForm;
use Monolegacy\Repositories\UserRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Psr7\Factory\ResponseFactory;

class LoginController extends Controller
{
    #[Inject]
    private LoginForm $loginForm;

    #[Inject]
    private UserRepository $userRepository;

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        if ($request->getMethod() == 'POST') {
            if ($this->loginForm->validate($request)) {
                $user = $this->userRepository->findByEmail($this->loginForm->email);

                if ($user && password_verify($this->loginForm->password, $user->password)) {
                    $_SESSION = ['userid' => (int)$user->id, 'loggedin' => true];

                    session_regenerate_id(true);
                    session_write_close();

                    return (new ResponseFactory())
                        ->createResponse(302)
                        ->withHeader('Location', '/');
                }

                $this->loginForm->setErrors(['email' => 'Invalid credentials']);
            }
        }

        return $this->view('login', [
            'form' => $this->loginForm,
        ]);
    }
}
