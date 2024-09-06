<?php

namespace App\Controllers;

use App\Repositories\UserRepository;
use DI\Attribute\Inject;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Respect\Validation\Validator as V;

class LoginController extends Controller
{
    #[Inject]
    private UserRepository $repo;

    public function get(): Response
    {
        return $this->view('login.twig');
    }

    public function post(Request $request, Response $response): Response
    {
        $rules = [
            'email' => V::stringType()->notBlank()->email(),
            'password' => V::stringType()->notBlank(),
        ];
        [$validated, $errors] = $this->validate($request, $rules);

        if (count($errors)) {
            $_SESSION['form'] = [
                'errors' => $errors,
                'fields' => $validated,
            ];
            return $this->redirect('/login');
        }

        $user = $this->repo->getForEmail($validated['email']);
        if (!$user || ($user->password !== md5($user->salt . md5($validated['password'])))) {
            $_SESSION['form'] = [
                'errors' => ['email' => 'Invalid Credentials'],
                'fields' => $validated,
            ];

            return $this->redirect('/login');
        }

        $this->repo->updateLastLogin($user->id);

        $_SESSION = [
            'userid' => (int)$user->id,
            'loggedin' => true,
        ];
        session_regenerate_id();

        return $this->redirect('/');
    }
}
