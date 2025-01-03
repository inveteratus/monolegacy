<?php

namespace Monolegacy\Validation\Rules;

use Monolegacy\Repositories\UserRepository;
use Respect\Validation\Rules\AbstractRule;

class UniqueEmail extends AbstractRule
{
    public function __construct(private UserRepository $repo)
    { }

    public function validate($input): bool
    {
        return is_string($input) && !$this->repo->emailExists($input);
    }
}
