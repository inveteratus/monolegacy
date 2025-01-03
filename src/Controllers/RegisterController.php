<?php

namespace Monolegacy\Controllers;

use DI\Attribute\Inject;
use Monolegacy\Repositories\UserRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Respect\Validation\Validator as V;
use Slim\Psr7\Factory\ResponseFactory;

class RegisterController extends Controller
{
    #[Inject]
    private UserRepository $repo;

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $form = [];
        $errors = [];

        if ($request->getMethod() == 'POST') {
            $form = $this->validate($request, [
                'name' => V::stringType()->notEmpty()->length(max:25)->uniqueName($this->repo),
                'email' => V::stringType()->notEmpty()->email()->uniqueEmail($this->repo),
                'password' => V::stringType()->notEmpty()->length(8),
            ]);

            if (count($form->errors)) {
                $errors = $form->errors;
            }
            else {
                return $this->register($form['name'], $form['email'], $form['password']);
            }
        }

        return $this->view('register', array_merge($form->values, ['errors' => $errors]));
    }

    private function register(string $name, string $email, string $password): ResponseInterface
    {
        $_SESSION = [
            'userid' => $this->repo->create($name, $email, $password),
            'loggedin' => true,
        ];

        session_regenerate_id(true);
        session_write_close();

        return (new ResponseFactory())
            ->createResponse(302)
            ->withHeader('Location', '/');
    }
}
