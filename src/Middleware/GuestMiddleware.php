<?php

namespace App\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Message\ResponseInterface as Response;

class GuestMiddleware
{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $userId = array_key_exists('userid', $_SESSION) ? (int) $_SESSION['userid'] : 0;

        if ($userId) {
            header('/index.php');
            exit;
        }

        return $handler->handle($request);
    }
}
