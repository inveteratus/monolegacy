<?php

namespace App\Controllers;

use App\Classes\View;
use App\Repositories\UserRepository;
use DI\Attribute\Inject;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Respect\Validation\Validator as V;

class LoginController
{
    #[Inject]
    protected UserRepository $repo;

    #[Inject]
    protected View $view;

    public function get(): Response
    {
        return $this->view->render('login.twig');
    }

    public function post(Request $request, Response $response): Response
    {
        $rules = [
            'email' => V::stringType()->notBlank()->email(),
            'password' => V::stringType()->notBlank(),
        ];
        [$validated, $errors] = validate($request, $rules);

        if (count($errors)) {
            $_SESSION['form'] = [
                'errors' => $errors,
                'fields' => $validated,
            ];

            return redirect('/login');
        }

        $user = $this->repo->getForEmail($validated['email']);
        if (!$user || ($user->password !== md5($user->salt . md5($validated['password'])))) {
            $_SESSION['form'] = [
                'errors' => ['email' => 'Invalid Credentials'],
                'fields' => $validated,
            ];

            return redirect('/login');
        }

        $this->repo->login($user->id);

        $_SESSION = [
            'userid' => (int)$user->id,
            'loggedin' => true,
        ];
        session_regenerate_id();

        return redirect('/home');
    }
}
