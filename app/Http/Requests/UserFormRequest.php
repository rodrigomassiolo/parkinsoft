<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {//
        return [
            'genero' => 'required|string|max:1',
            'nacimiento' => 'required|date',
            'password' => 'required|string|min:6|confirmed',
        ];

    }
}
