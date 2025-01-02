<?php

namespace Monolegacy\Controllers;

use DI\Attribute\Inject;
use eftec\bladeone\BladeOne;
use Monolegacy\Repositories\UserRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Psr7\Factory\ResponseFactory;

class LoginController
{
    #[Inject]
    private BladeOne $blade;

    #[Inject]
    private UserRepository $repo;

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $email = '';
        $errors = [];

        if ($request->getMethod() == 'POST') {
            $body = $request->getParsedBody();

            $email = is_array($body) && array_key_exists('email', $body) && is_string($body['email'])
                ? trim($body['email'])
                : '';
            $password = is_array($body) && array_key_exists('password', $body) && is_string($body['password'])
                ? trim($body['password'])
                : '';

            if (!strlen($email)) {
                $errors['email'] = 'Email is required';
            }
            else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'Invalid email';
            }

            if (!strlen($password)) {
                $errors['password'] = 'Password is required';
            }

            if (!count($errors)) {
                $user = $this->repo->findByEmail($email);
                if ($user && $this->passwordVerify($password, $user->password)) {
                    return $this->login($user->id);
                }

                $errors['email'] = 'Invalid credentials';
            }
        }

        $response = (new ResponseFactory())
            ->createResponse();
        $response->getBody()
            ->write($this->blade->run('login', ['email' => $email, 'errors' => $errors]));

        return $response;
    }

    private function passwordVerify($password, $hash)
    {
        [$salt, $stored] = explode('$', $hash);

        return md5($salt . md5($password)) === $stored;
    }

    private function login(int $uid): ResponseInterface
    {
        $_SESSION = [
            'userid' => $uid,
            'loggedin' => true,
        ];

        session_regenerate_id(true);
        session_write_close();

        return (new ResponseFactory())
            ->createResponse(302)
            ->withHeader('Location', '/');
    }
}
