<?php

namespace App\Extensions;

use Psr\Http\Message\UriInterface;
use Slim\Interfaces\RouteParserInterface;

class SlimRuntimeExtension
{
    public function __construct(
        protected RouteParserInterface $routeParser,
        protected UriInterface         $uri,
        protected string               $basePath = ''
    )
    {
    }

    public function currentUrl(bool $withQueryString = false): string
    {
        $currentUrl = $this->basePath . $this->uri->getPath();
        $query = $this->uri->getQuery();

        if ($withQueryString && !empty($query)) {
            $currentUrl .= '?' . $query;
        }

        return $currentUrl;
    }

    public function fullUrlUrl(string $route, array $params = [], array $queryParams = []): string
    {
        return $this->routeParser->fullUrlFor($this->uri, $route, $params, $queryParams);
    }

    public function isCurrentUrl(string $routeName, array $data = []): bool
    {
        $currentUrl = $this->basePath . $this->uri->getPath();
        $result = $this->routeParser->urlFor($routeName, $data);

        return $result === $currentUrl;
    }

    public function urlFor(string $route, array $params = [], array $queryParams = []): string
    {
        return $this->routeParser->urlFor($route, $params, $queryParams);
    }
}
