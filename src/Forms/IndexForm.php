<?php

namespace Monolegacy\Forms;

use Respect\Validation\Validator as V;

class IndexForm extends Form
{
    public string $notes = '';

    public function rules(): array
    {
        return [
            'notes' => V::optional(V::stringType()),
        ];
    }
}