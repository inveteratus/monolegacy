<?php

namespace App\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Message\ResponseInterface as Response;

class SessionMiddleware
{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        session_start(['name' => 'MCCSID']);

        return $handler->handle($request);
    }
}
