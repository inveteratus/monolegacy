<?php

namespace App\Extensions;

use Slim\Interfaces\RouteParserInterface;
use Twig\RuntimeLoader\RuntimeLoaderInterface;

class SlimRuntimeLoader implements RuntimeLoaderInterface
{
    public function __construct(protected RouteParserInterface $routeParser)
    {
    }

    public function load(string $class)
    {
        if ($class === SlimRuntimeExtension::class) {
            return new $class($this->routeParser);
        }

        return null;
    }
}
