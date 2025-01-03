<?php

namespace Monolegacy\Classes;

use ArrayAccess;
use RuntimeException;

readonly class ValidationResponse implements ArrayAccess
{
    public function __construct(public array $values, public array $errors)
    {
    }

    public function offsetExists(mixed $offset): bool
    {
        return array_key_exists($offset, $this->values);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->values[$offset];
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        throw new RuntimeException("Validation response is read-only");
    }

    public function offsetUnset(mixed $offset): void
    {
        throw new RuntimeException("Validation response is read-only");
    }
}
