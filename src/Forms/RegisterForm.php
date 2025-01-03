<?php

namespace Monolegacy\Forms;

use Monolegacy\Repositories\UserRepository;
use Respect\Validation\Validator as V;

class RegisterForm extends Form
{
    public string $name = '';
    public string $email = '';
    public string $password = '';

    public function __construct(private readonly UserRepository $userRepository)
    { }

    public function rules(): array
    {
        return [
            'name' => V::stringType()->notEmpty()->length(max:25)->uniqueName($this->userRepository),
            'email' => V::stringType()->notEmpty()->email()->uniqueEmail($this->userRepository),
            'password' => V::stringType()->notEmpty()->length(8),
        ];
    }
}