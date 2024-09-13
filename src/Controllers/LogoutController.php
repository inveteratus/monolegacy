<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Request;
use Slim\Routing\RouteContext;

class LogoutController
{
    public function __invoke(Request $request): ResponseInterface
    {
        // We don't care if attacking is set, we'll pick that up on login

        $_SESSION = [];
        session_regenerate_id(true);

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        return redirect($routeParser->urlFor('index'));
    }
}
