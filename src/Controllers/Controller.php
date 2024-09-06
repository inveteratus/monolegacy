<?php

namespace App\Controllers;

use DI\Attribute\Inject;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator as v;
use Slim\Psr7\Factory\ResponseFactory;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\TwigFunction;

abstract class Controller
{
    #[Inject]
    private Environment $environment;

    public function redirect(string $url): Response
    {
        session_write_close();

        $responseFactory = new ResponseFactory();

        return $responseFactory->createResponse()
            ->withStatus(StatusCodeInterface::STATUS_FOUND)
            ->withHeader('Location', $url);
    }

    public function validate(Request $request, array $rules): array
    {
        $errors = [];
        $inputs = (array)$request->getParsedBody();
        $validator = null;

        foreach ($rules as $field => $rule) {
            if (is_null($validator)) {
                $validator = v::key($field, $rule);
            } else {
                $validator->key($field, $rule);
            }
        }

        try {
            $validator->assert($inputs);
        } catch (NestedValidationException $nve) {
            $errors = $nve->getMessages();
        }

        $keys = array_keys($rules);
        $blank = array_fill_keys($keys, null);
        $populated = array_intersect_key($inputs, $rules);
        $validated = array_merge($blank, $populated);

        return [$validated, $errors];
    }

    public function view(string $template, array $context = []): Response
    {
        $this->environment->addExtension(new DebugExtension());
        $this->environment->addFunction(new TwigFunction('old', function (string $field) {
            return $_SESSION['form']['fields'][$field] ?? null;
        }));
        $this->environment->addFunction(new TwigFunction('error', function (string $field) {
            return $_SESSION['form']['errors'][$field] ?? null;
        }));

        $responseFactory = new ResponseFactory();
        $response = $responseFactory->createResponse();
        $response->getBody()->write($this->environment->render($template, $context));

        unset($_SESSION['form']);

        return $response;
    }
}
