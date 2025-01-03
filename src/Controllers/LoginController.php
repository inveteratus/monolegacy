<?php

namespace Monolegacy\Controllers;

use DI\Attribute\Inject;
use Monolegacy\Repositories\UserRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Respect\Validation\Validator as V;
use Slim\Psr7\Factory\ResponseFactory;

class LoginController extends Controller
{
    #[Inject]
    private UserRepository $repo;

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $form = [];
        $errors = [];

        if ($request->getMethod() == 'POST') {
            $form = $this->validate($request, [
                'email' => V::stringType()->notEmpty()->email(),
                'password' => V::stringType()->notEmpty(),
            ]);

            if (count($form->errors)) {
                $errors = $form->errors;
            }
            else {
                $user = $this->repo->findByEmail($form['email']);
                if ($user && $this->passwordVerify($form['password'], $user->password)) {
                    return $this->login($user->id);
                }

                $errors = ['email' => 'Invalid credentials'];
            }
        }

        return $this->view('login', array_merge($form->values, ['errors' => $errors]));
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
