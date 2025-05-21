<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class DocumentationRequest extends FormRequest
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
            'type' => 'nullable|string|in:create,update',
            'documentation' => 'nullable|string',

        ]
            +
            ($this->isMethod('POST') ? $this->store() : $this->update());
    }

    protected function store(): array
    {
        return [
            'title' => 'required|unique:documentations,title',
            'module_key' => 'required|unique:documentations,module_key',
        ];
    }


    protected function update(): array
    {
        return [
            'title' => 'required|unique:documentations,title,' . decrypt($this->route('documentation')),
            'module_key' => 'required|unique:documentations,module_key,' .decrypt($this->route('documentation')),
        ];
    }
}
