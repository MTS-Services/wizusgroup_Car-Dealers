<?php

namespace App\Http\Requests\Admin\SupllierManagement;

use Illuminate\Foundation\Http\FormRequest;

class SupplierRequest extends FormRequest
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
            'image' => 'nullable',

        ]
            +
            ($this->isMethod('POST') ? $this->store() : $this->update());
    }

    protected function store(): array
    {
        return [
            'email' => 'required|unique:suppliers,email',
            'password' => 'required|min:6|confirmed',
            'username' => [
                'nullable',
                'unique:suppliers,username',
                'regex:/^[a-zA-Z0-9\-]+$/',
            ],
        ];
    }


    protected function update(): array
    {
        return [
            'email' => 'required|unique:suppliers,email,' . decrypt($this->route('supplier')),
            'password' => 'nullable|min:6|confirmed',
            'username' => [
                'nullable',
                'unique:suppliers,username,' . decrypt($this->route('supplier')),
                'regex:/^[a-zA-Z0-9\-]+$/',
            ],
        ];
    }
}
