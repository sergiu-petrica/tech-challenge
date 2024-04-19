<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'max:190',
            ],
            'email' => [
                'nullable',
                'required_without:phone',
                'email',
            ],
            'phone' => [
                'nullable',
                'required_without:email',
                'regex:/^[+0-9\s]+$/',
            ],
        ];
    }
}
