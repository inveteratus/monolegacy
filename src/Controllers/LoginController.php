<?php

namespace Monolegacy\Controllers;

use DI\Attribute\Inject;
use Monolegacy\Repositories\UserRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Psr7\Response;

class LoginController
{
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

        return $this->view(['email' => $email, 'errors' => $errors]);
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

        return (new Response())
            ->withStatus(302)
            ->withHeader('Location', '/');
    }

    private function view(array $context)
    {
        $email = $context['email'];
        $errors = array_merge(['email' => '', 'password' => ''], $context['errors']);
        $errors = array_map(fn ($error) => $error ? ('<span class="text-sm text-red-500">' . htmlentities($error) . '</span>') : '', $errors);

        $html = <<<HTML
            <!DOCTYPE html>
            <html lang="en-GB">
            <head>
                <meta charset="utf-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width,initial-scale=1">
                <title>Monolegacy</title>
                <script src="https://cdn.tailwindcss.com"></script>
            </head>
            <body class="bg-slate-200 flex flex-col items-center justify-center min-h-screen text-slate-700">
                <form action="/login.php" method="post" class="bg-slate-100 rounded-md px-8 py-6 shadow border border-slate-300 max-w-md w-full flex flex-col space-y-3">
                    <div class="flex flex-col space-y-1">
                        <label for="email" class="text-sm font-medium text-slate-600">Email</label>
                        <input id="email" type="email" name="email" value="{$email}" autofocus autocomplete="email" required class="p-2 border border-slate-300 bg-white focus:outline-none focus:ring-1 focus:ring-blue-500 focus:ring-offset-0 focus:border-blue-500 rounded" />
                        {$errors['email']}            
                    </div>            
                    <div class="flex flex-col space-y-1">
                        <label for="password" class="text-sm font-medium text-slate-600">Password</label>            
                        <input id="password" type="password" name="password" autocomplete="current-password" required class="p-2 border border-slate-300 bg-white focus:outline-none focus:ring-1 focus:ring-blue-500 focus:ring-offset-0 focus:border-blue-500 rounded" />
                        {$errors['password']}            
                    </div>            
                    <div class="flex pt-3">
                        <button type="submit" class="bg-blue-500 text-white font-medium px-3 py-2 rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-offset-slate-100 focus:ring-blue-500">Login</button>
                    </div>            
                </form>
                <p class="pt-2 text-center text-sm"><a href="/register.php" class="text-slate-700 hover:underline focus:underline focus:outline-none">Not got an account yet ?</a></p>
            </body>
            </html>
        HTML;

        $response = (new Response())->withStatus(200);
        $response->getBody()->write($html);

        return $response;
    }
}
