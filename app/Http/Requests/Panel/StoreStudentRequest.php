<?php

namespace App\Http\Requests\Panel;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'first_name' => ['required', 'string', 'max:255', 'min:1'],
            'last_name' => ['required', 'string', 'max:255', 'min:1'],
            'birth_date' => ['required', 'date'],
            'class_id' => ['required', 'exists:student_classes,id'],
            'phone' => ['nullable', 'string'],
            'mobile_phone' => ['nullable', 'string'],
            'email' => ['required', 'unique:users,email'],
        ];
    }
}
