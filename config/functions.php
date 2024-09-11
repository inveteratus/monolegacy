<?php

use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator as V;
use Slim\Psr7\Factory\ResponseFactory;
use Slim\Psr7\Request;

if (!function_exists('redirect')) {
    function redirect(string $url, int $status = StatusCodeInterface::STATUS_FOUND): ResponseInterface
    {
        return (new ResponseFactory())
            ->createResponse($status)
            ->withHeader('Location', $url);
    }
}

if (!function_exists('validate')) {
    function validate(Request $request, array $rules): array
    {
        $errors = [];
        $inputs = (array)$request->getParsedBody();
        $validator = null;

        foreach ($rules as $field => $rule) {
            if (is_null($validator)) {
                $validator = V::key($field, $rule);
            } else {
                $validator->key($field, $rule);
            }
        }

        try {
            $validator->assert($inputs);
        } catch (NestedValidationException $exception) {
            $errors = $exception->getMessages();
        }

        return [
            array_merge(array_fill_keys(array_keys($rules), null), array_intersect_key($inputs, $rules)),
            $errors
        ];
    }
}
