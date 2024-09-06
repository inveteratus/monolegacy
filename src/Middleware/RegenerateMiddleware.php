<?php

namespace App\Middleware;

use App\Repositories\UserRepository;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Message\ResponseInterface as Response;

class RegenerateMiddleware
{
    public function __construct(private UserRepository $repository)
    {
    }

    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $uid = $request->getAttribute('uid');
        $this->repository->regenerate($uid);

        return $handler->handle($request);
    }
}
