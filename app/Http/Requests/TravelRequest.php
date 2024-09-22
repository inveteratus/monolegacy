<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TravelRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'destination' => 'required|integer|exists:cities,id',
        ];
    }
}
