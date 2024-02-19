<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
class ItemFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // if (!auth()->check() || !session()->has('admin')) {
        //     abort(403, 'Unauthorized action.');
        // }
        return true;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {

        return [
            'name' => 'required|max:100',
            'detail' => 'max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ];
    }
}
