<?php

namespace App\Controllers;

use App\Classes\Database;
use App\Classes\View;
use App\Repositories\UserRepository;
use DI\Attribute\Inject;
use Psr\Http\Message\ResponseInterface as Response;
use Respect\Validation\Validator as V;
use Slim\Psr7\Request;
use Slim\Routing\RouteContext;

class RegisterController
{
    #[Inject]
    protected UserRepository $userRepository;

    #[Inject]
    protected Database $db;

    #[Inject]
    protected View $view;

    public function get(Request $request, Response $response): Response
    {
        return $this->view->render('register.twig');
    }

    public function post(Request $request, Response $response): Response
    {
        $routeParser = RouteContext::fromRequest($request)->getRouteParser();

        $rules = [
            'name' => v::stringType()->notBlank()->length(3, 25)->isUnique($this->db, 'users', 'name'),
            'email' => v::stringType()->notBlank()->email()->isUnique($this->db, 'users', 'email'),
            'password' => v::stringType()->notBlank()->length(6),
        ];
        [$validated, $errors] = validate($request, $rules);

        if (count($errors)) {
            $_SESSION['form'] = [
                'errors' => $errors,
                'fields' => $validated,
            ];

            return redirect($routeParser->urlFor('register'));
        }

        $name = trim($validated['name']);
        $email = trim($validated['email']);
        $password = trim($validated['password']);
        $id = $this->userRepository->create($name, $email, $password);

        $this->userRepository->login($id);

        $_SESSION = [
            'userid' => (int)$id,
            'loggedin' => true,
        ];
        session_regenerate_id();

        return redirect($routeParser->urlFor('home'));
    }
}
