<?php

namespace Monolegacy\Controllers;

use DI\Attribute\Inject;
use eftec\bladeone\BladeOne;
use Monolegacy\Forms\Form;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Factory\ResponseFactory;

class Controller
{
    #[Inject]
    private BladeOne $blade;

    public function view(string $view, array $context = []): ResponseInterface
    {
        $response = (new ResponseFactory())->createResponse();
        $errors = [];

        foreach ($context as $key => $value) {
            if ($value instanceof Form) {
                $errors = array_merge($errors, $value->getErrors());
            }
        }

        $this->blade->setErrorFunction(
            fn(string $key) => array_key_exists($key, $errors) ? $errors[$key] : null
        );

        $response->getBody()->write($this->blade->run($view, $context));

        return $response;
    }
}
