<?php

namespace App\Controllers;

use App\Classes\View;
use App\Repositories\UserRepository;
use DI\Attribute\Inject;
use Psr\Http\Message\ResponseInterface;
use Respect\Validation\Validator as V;
use Slim\Psr7\Request;
use Slim\Routing\RouteContext;

class LoginController
{
    #[Inject]
    protected UserRepository $repo;

    #[Inject]
    protected View $view;

    public function get(): ResponseInterface
    {
        return $this->view->render('login.twig');
    }

    public function post(Request $request): ResponseInterface
    {
        $routeParser = RouteContext::fromRequest($request)->getRouteParser();

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

            return redirect($routeParser->urlFor('login'));
        }

        $user = $this->repo->getByEmail($validated['email']);
        if (!$user || ($user->password !== md5($user->salt . md5($validated['password'])))) {
            $_SESSION['form'] = [
                'errors' => ['email' => 'Invalid Credentials'],
                'fields' => $validated,
            ];

            return redirect($routeParser->urlFor('login'));
        }

        $_SESSION = [
            'userid' => (int)$user->id,
            'loggedin' => true,
        ];
        session_regenerate_id();

        return redirect($routeParser->urlFor('home'));
    }
}
