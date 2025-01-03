<?php

namespace Monolegacy\Forms;

use Respect\Validation\Validator as V;

class LoginForm extends Form
{
    public string $email = '';
    public string $password = '';

    public function rules(): array
    {
        return [
            'email' => V::stringType()->notEmpty()->email(),
            'password' => V::stringType()->notEmpty(),
        ];
    }
}
