<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JournalStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'journal_content' => [
                'required',
                'string',
            ],
            'client_id' => [
                'required',
                'integer',
            ],
        ];
    }

    public function all($keys = null)
    {
        $data = parent::all($keys);
        $data['client_id'] = $this->route('client_id');

        return $data;
    }
}
