<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class UserPasswordUpdateRequest extends FormRequest
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
            'old_password' => [

                'required',

                'sometimes',

                function ($attribute, $value, $fail) {

                    if (!$this->checkOldPassword($value)) {

                        $fail("The $attribute doesn't match the current password.");
                    }
                },

            ],

            'password' => 'required|confirmed',
        ];
    }
    /**

     * Check if the given password matches the current user's password.

     *

     * @param string $password

     * @return bool

     */

    private function checkOldPassword(string $password): bool

    {

        return Hash::check($password, user()->password);
    }
}
