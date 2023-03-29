<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, Rule|array|string>
     */
    public function rules(): array
    {

        return [
            'name' => 'string|max:255',
            'email' => 'email:dns|unique:users',
        ];
    }
}
