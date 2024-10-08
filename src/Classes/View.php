<?php

namespace App\Classes;

use App\Extensions\SlimExtension;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Factory\ResponseFactory;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Extension\ExtensionInterface;
use Twig\Loader\FilesystemLoader;
use Twig\RuntimeLoader\RuntimeLoaderInterface;
use Twig\TwigFunction;

class View
{
    protected Environment $twig;

    public function __construct(array|string $path, array $settings = [])
    {
        $this->twig = new Environment(new FilesystemLoader($path), $settings);

        // Extensions
        $this->addExtension(new DebugExtension());
        $this->addExtension(new SlimExtension());

        // Filters

        // Functions
        foreach (['ceil', 'floor', 'is_object'] as $function) {
            $this->twig->addFunction(new TwigFunction($function, $function));
        }

        // TODO Move to the DataExtension
        $this->twig->addFunction(new TwigFunction('inmates', fn () => 123));
        $this->twig->addFunction(new TwigFunction('patients', fn () => 456));
        $this->twig->addFunction(new TwigFunction('old', function (string $field) {
            return $_SESSION['form']['fields'][$field] ?? null;
        }));
        $this->twig->addFunction(new TwigFunction('error', function (string $field) {
            return $_SESSION['form']['errors'][$field] ?? null;
        }));
    }

    public function addExtension(ExtensionInterface $extension): self
    {
        $this->twig->addExtension($extension);

        return $this;
    }

    public function addRuntimeLoader(RuntimeLoaderInterface $runtimeLoader): self
    {
        $this->twig->addRuntimeLoader($runtimeLoader);

        return $this;
    }

    public function fetch(string $template, array $context = []): string
    {
        return $this->twig->render($template, $context);
    }

    public function render(string $template, array $context = []): ResponseInterface
    {
        $response = (new ResponseFactory())->createResponse();
        $response->getBody()->write($this->fetch($template, $context));

        return $response;
    }
}
