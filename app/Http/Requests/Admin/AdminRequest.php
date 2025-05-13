<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
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
            'first_name' => 'required|string|min:4',
            'last_name' => 'required|string|min:4',
            'role' => 'required|exists:roles,id',
            'image' => 'nullable',

        ]
            +
            ($this->isMethod('POST') ? $this->store() : $this->update());
    }

    protected function store(): array
    {
        return [
            'email' => 'required|unique:admins,email',
            'password' => 'required|min:6|confirmed',
            'username' => [
                'nullable',
                'unique:admins,username',
                'regex:/^[a-zA-Z0-9\-]+$/',
            ],
        ];
    }


    protected function update(): array
    {
        return [
            'email' => 'required|unique:admins,email,' . decrypt($this->route('admin')),
            'password' => 'nullable|min:6|confirmed',
            'username' => [
                'nullable',
                'unique:admins,username,' . decrypt($this->route('admin')),
                'regex:/^[a-zA-Z0-9\-]+$/',
            ],
        ];
    }
}
