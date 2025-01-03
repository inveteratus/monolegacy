<?php

namespace Monolegacy\Controllers;

use DI\Attribute\Inject;
use eftec\bladeone\BladeOne;
use Monolegacy\Classes\ValidationResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Respect\Validation\Exceptions\NestedValidationException;
use Slim\Psr7\Factory\ResponseFactory;

class Controller
{
    #[Inject]
    private BladeOne $blade;

    public function validate(ServerRequestInterface $request, array $rules): ValidationResponse
    {
        $body = $request->getParsedBody();
        if (!is_array($body)) {
            $body = [];
        }

        $values = [];
        $errors = [];

        foreach ($rules as $field => $rule) {
            $values[$field] = is_array($body[$field]) ? $body[$field] : trim($body[$field]);

            try {
                $rule->setName($field)->assert($body[$field] ?? null);
            }
            catch (NestedValidationException $e) {
                $errors[$field] = $e->getMessages()[$field];
            }
        }

        return new ValidationResponse($values, $errors);
    }

    public function view(string $view, array $context = []): ResponseInterface
    {
        $response = (new ResponseFactory())->createResponse();
        $response->getBody()->write($this->blade->run($view, $context));

        return $response;
    }
}
