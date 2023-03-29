<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, Rule|array|string>
     */
    public function rules(): array
    {

        return [
            'old_password' => 'required',
            'password' => 'required|min:8|',
            'confirm_password' => 'required|same:password'
        ];
    }
}
