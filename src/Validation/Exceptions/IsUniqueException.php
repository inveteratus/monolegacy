<?php

namespace App\Validation\Exceptions;

use Respect\Validation\Exceptions\ValidationException;

class IsUniqueException extends ValidationException
{
    protected $defaultTemplates = [
        self::MODE_DEFAULT => [
            self::STANDARD => '{{name}} already exists',
        ],
        self::MODE_NEGATIVE => [
            self::STANDARD => '{{name}} does not exist',
        ],
    ];
}
