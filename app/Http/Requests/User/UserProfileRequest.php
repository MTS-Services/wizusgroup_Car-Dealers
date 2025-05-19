<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserProfileRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|min:3',
            'last_name' => 'required|string|min:3',
            'username' => 'nullable|string|min:3',
            // 'email' => 'required|email|unique:users,email,',
            'phone' => 'nullable|string|size:11',
            'image' => 'nullable',
            'gender' => 'nullable',
            'dob' => 'nullable|date',
            'father_name' => 'nullable|string|min:3',
            'mother_name' => 'nullable|string|min:3',
            'emergency_phone' => 'nullable|string|min:3',
            'nationality' => 'nullable|string|min:3',
            'bio' => 'nullable|string|min:3',
        ];
    }
}
