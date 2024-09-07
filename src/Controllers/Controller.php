<?php

namespace App\Controllers;

use App\Repositories\PlayerRepository;
use Carbon\Carbon;
use DI\Attribute\Inject;
use Fig\Http\Message\StatusCodeInterface;
use League\CommonMark\CommonMarkConverter;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator as v;
use Slim\Psr7\Factory\ResponseFactory;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

abstract class Controller
{
    #[Inject]
    private Environment $environment;

    #[Inject]
    private PlayerRepository $playerRepository;

    private CommonMarkConverter $markdown;

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

        $this->environment->addFunction(new TwigFunction('min', 'min'));
        $this->environment->addFunction(new TwigFunction('max', 'max'));
        $this->environment->addFunction(new TwigFunction('number_format', 'number_format'));
        $this->environment->addFunction(new TwigFunction('floor', 'floor'));
        $this->environment->addFunction(new TwigFunction('ceil', 'ceil'));
        $this->environment->addFunction(new TwigFunction('is_object', 'is_object'));
        $this->environment->addFunction(new TwigFunction('sprintf', 'is_object'));

        $this->environment->addFunction(new TwigFunction('inmates', fn () => $this->playerRepository->numInmates()));
        $this->environment->addFunction(new TwigFunction('patients', fn () => $this->playerRepository->numPatients()));

        $this->environment->addFunction(new TwigFunction('old', function (string $field) {
            return $_SESSION['form']['fields'][$field] ?? null;
        }));
        $this->environment->addFunction(new TwigFunction('error', function (string $field) {
            return $_SESSION['form']['errors'][$field] ?? null;
        }));
        $this->environment->addFilter(new TwigFilter('delta', function (string $dateTime) {
            return Carbon::parse($dateTime)->diffForHumans(null, parts:2);
        }));
        $this->environment->addFilter(new TwigFilter('markdown', function (string $markup) {
            return $this->markdown->convert($markup);
        }));

        $responseFactory = new ResponseFactory();
        $response = $responseFactory->createResponse();
        $response->getBody()->write($this->environment->render($template, $context));

        unset($_SESSION['form']);

        return $response;
    }
}
