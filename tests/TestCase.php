<?php

namespace tests;

use App\Extensions\SlimMiddleware;
use DI\ContainerBuilder;
use PHPUnit\Framework\TestCase as BaseTestCase;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Psr7\Factory\StreamFactory;
use Slim\Psr7\Headers;
use Slim\Psr7\Request as SlimRequest;
use Slim\Psr7\Uri;

class TestCase extends BaseTestCase
{
    protected function getAppInstance(): App
    {
        $container = (new ContainerBuilder())
            ->useAttributes(true)
            ->useAutowiring(true)
            ->addDefinitions(__DIR__ . '/../config/container.php')
            ->addDefinitions(__DIR__ . '/../config/dependencies.php')
            ->build();

        $app = $container->get(App::class);
        $app->add(new SlimMiddleware($app));

        return $app;
    }

    protected function createRequest(
        string $method,
        string $path,
        array $headers = [],
        array $cookies = [],
        array $serverParams = []
    ): Request {
        $uri = new Uri('', '', 80, $path);
        $handle = fopen('php://temp', 'w+');
        $stream = (new StreamFactory())->createStreamFromResource($handle);

        $h = new Headers();
        foreach ($headers as $name => $value) {
            $h->addHeader($name, $value);
        }

        return new SlimRequest($method, $uri, $h, $cookies, $serverParams, $stream);
    }
}
