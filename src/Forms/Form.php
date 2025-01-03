<?php

namespace Monolegacy\Forms;

use Psr\Http\Message\ServerRequestInterface;
use Respect\Validation\Exceptions\NestedValidationException;

abstract class Form
{
    private array $messages = [];

    abstract public function rules(): array;

    public function validate(ServerRequestInterface $request): bool
    {
        $body = $request->getParsedBody();
        if (!is_array($body)) {
            $body = [];
        }

        foreach ($this->rules() as $field => $rule) {
            $this->setValue($field, array_key_exists($field, $body) ? $body[$field] : null);

            try {
                $rule->setName($field)->assert($body[$field] ?? null);
            }
            catch (NestedValidationException $e) {
                $this->messages[$field] = $e->getMessages()[$field];
            }
        }

        return !count($this->messages);
    }

    public function getErrors(): array
    {
        return $this->messages;
    }

    public function setErrors(array $errors): void
    {
        $this->messages = $errors;
    }

    private function setValue(string $field, mixed $value): void
    {
        if (is_string($value)) {
            $this->{$field} = trim($value);
        }
    }
}
