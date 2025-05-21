<?php

namespace App\Http\Requests\Admin\ProductManagement;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
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
            'description' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'meta_title' => 'nullable|string',
            'image'=> 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
            'website'=> 'nullable|url',

        ]
            +
            ($this->isMethod('POST') ? $this->store() : $this->update());
    }

    protected function store(): array
    {
        return [
            'name' => 'required|unique:companies,name',
            'slug' => 'required|unique:companies,slug',
        ];
    }


    protected function update(): array
    {
        return [
            'name' => 'required|unique:companies,name,' . decrypt($this->route('company')),
            'slug' => 'required|unique:companies,slug,' . decrypt($this->route('company')),
        ];
    }
}
