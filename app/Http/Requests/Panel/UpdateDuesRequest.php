<?php

namespace App\Http\Requests\Panel;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDuesRequest extends FormRequest
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
            'dues_id' => 'required|integer|exists:duesses,id',
            'user_id' => 'required|integer|exists:users,id',
            'status' => 'required|string|min:1|max:255',
        ];
    }
}
