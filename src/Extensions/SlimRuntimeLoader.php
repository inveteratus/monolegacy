<?php

namespace App\Extensions;

use Psr\Http\Message\UriInterface;
use Slim\Interfaces\RouteParserInterface;
use Twig\RuntimeLoader\RuntimeLoaderInterface;

class SlimRuntimeLoader implements RuntimeLoaderInterface
{
    public function __construct(protected RouteParserInterface $routeParser, protected UriInterface $uri)
    {
    }

    public function load(string $class)
    {
        if ($class === SlimRuntimeExtension::class) {
            return new $class($this->routeParser, $this->uri);
        }

        return null;
    }
}
