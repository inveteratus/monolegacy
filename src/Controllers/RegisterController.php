<?php

namespace Monolegacy\Controllers;

use DI\Attribute\Inject;
use eftec\bladeone\BladeOne;
use Monolegacy\Repositories\UserRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Psr7\Factory\ResponseFactory;

class RegisterController
{
    #[Inject]
    private BladeOne $blade;

    #[Inject]
    private UserRepository $repo;

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $name = $email = '';
        $errors = [];

        if ($request->getMethod() == 'POST') {
            $body = $request->getParsedBody();

            $name = is_array($body) && array_key_exists('name', $body) && is_string($body['name'])
                ? trim($body['name'])
                : '';
            $email = is_array($body) && array_key_exists('email', $body) && is_string($body['email'])
                ? trim($body['email'])
                : '';
            $password = is_array($body) && array_key_exists('password', $body) && is_string($body['password'])
                ? trim($body['password'])
                : '';

            if (!strlen($name)) {
                $errors['name'] = 'Name is required';
            }
            else if (strlen($name) > 25) {
                $errors['name'] = 'Name is too long';
            }
            else if ($this->repo->nameExists($name)) {
                $errors['name'] = 'Name already exists';
            }

            if (!strlen($email)) {
                $errors['email'] = 'Email is required';
            }
            else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'Invalid email';
            }
            else if ($this->repo->emailExists($email)) {
                $errors['email'] = 'Email already exists';
            }

            if (!strlen($password)) {
                $errors['password'] = 'Password is required';
            }
            else if (strlen($password) < 8) {
                $errors['password'] = 'Password is too short';
            }

            if (!count($errors)) {
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

        $response = (new ResponseFactory())
            ->createResponse();
        $response->getBody()
            ->write($this->blade->run('register', ['name' => $name, 'email' => $email, 'errors' => $errors]));

        return $response;
    }
}
