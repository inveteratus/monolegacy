<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BankRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'deposit' => 'required_without:withdraw|integer|min:100',
            'withdraw' => 'required_without:deposit|integer|min:100',
        ];
    }
}
