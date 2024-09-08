<?php

namespace App\Extensions;

use Slim\Interfaces\RouteParserInterface;

class SlimRuntimeExtension
{
    public function __construct(protected RouteParserInterface $routeParser)
    {
    }

    public function url(string $route, array $params = [], array $queryParams = []): string
    {
        return $this->routeParser->urlFor($route, $params, $queryParams);
    }
}
