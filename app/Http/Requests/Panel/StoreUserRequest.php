<?php

namespace App\Http\Requests\Panel;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'first_name' => ['required', 'string', 'min:1', 'max:255'],
            'last_name' => ['required', 'string', 'min:1', 'max:255'],
            'email' => ['required', 'string', 'unique:users,email'],
            'birth_date' => ['nullable', 'date'],
            'class_id' => ['nullable', 'integer', 'exists:student_classes,id'],
            'user_id' => ['nullable', 'integer', 'exists:users,id'],
            'role' => ['required', 'string', 'min:1', 'max:255'],
        ];
    }
}
