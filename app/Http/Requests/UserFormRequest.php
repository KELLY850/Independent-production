<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $this->route()->parameter('user');
        return [
            //
            'name' => ['required', 'string', 'max:255','regex:/^[^\d]+$/u'],
            'name_katakana' =>['required','string','max:255', 'regex:/^[\p{Han}\p{Katakana}\sー]+$/u'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        ];
    }
}
