<?php

namespace App\Middleware;

use App\Repositories\SeenRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class SeenMiddleware
{
    public function __construct(private SeenRepository $repository)
    {
    }

    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $this->repository->track($request->getAttribute('uid'));

        return $handler->handle($request);
    }
}
