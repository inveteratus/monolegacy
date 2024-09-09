<?php

namespace App\Extensions;

use App\Classes\View;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\App;
use Slim\Interfaces\RouteParserInterface;

class SlimMiddleware
{
    protected RouteParserInterface $routeParser;
    protected View $view;

    public function __construct(App $app)
    {
        $this->routeParser = $app->getRouteCollector()->getRouteParser();
        $this->view = $app->getContainer()->get(View::class);
    }

    public function __invoke(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $this->view->addRuntimeLoader(new SlimRuntimeLoader($this->routeParser, $request->getUri()));

        return $handler->handle($request);
    }
}
