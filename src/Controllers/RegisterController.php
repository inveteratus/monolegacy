<?php

namespace App\Controllers;

use App\Classes\Database;
use App\Repositories\UserRepository;
use DI\Attribute\Inject;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Respect\Validation\Validator as V;

class RegisterController extends Controller
{
    #[Inject]
    private Database $db;

    #[Inject]
    private UserRepository $repo;

    public function get(Request $request, Response $response): Response
    {
        return $this->view('register.twig');
    }

    public function post(Request $request, Response $response): Response
    {
        $rules = [
            'name' => v::stringType()->notBlank()->length(3, 25)->isUnique($this->db, 'users', 'username'),
            'email' => v::stringType()->notBlank()->email()->isUnique($this->db, 'users', 'email'),
            'password' => v::stringType()->notBlank()->length(6),
        ];
        [$validated, $errors] = $this->validate($request, $rules);

        if (count($errors)) {
            $_SESSION['form'] = [
                'errors' => $errors,
                'fields' => $validated,
            ];
            return $this->redirect('/register');
        }

        $name = trim($validated['name']);
        $email = trim($validated['email']);
        $password = trim($validated['password']);

        $this->repo->create($name, $email, $password);

        return $this->redirect('/login');
    }
}
