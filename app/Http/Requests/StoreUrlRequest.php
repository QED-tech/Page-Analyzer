<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUrlRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'url.name' => 'required|url'
        ];
    }

    public function messages(): array
    {
        return [
            'url.name.url' => 'Некорректный URL'
        ];
    }
}
