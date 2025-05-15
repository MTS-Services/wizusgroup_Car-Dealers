<?php

namespace App\Http\Requests\Admin\ProductManagement;

use Illuminate\Foundation\Http\FormRequest;

class BrandRequest extends FormRequest
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
            'logo'=> 'nullable',
            'website'=> 'nullable|url',

        ]
            +
            ($this->isMethod('POST') ? $this->store() : $this->update());
    }

    protected function store(): array
    {
        return [
            'name' => 'required|unique:brands,name',
            'slug' => 'required|unique:brands,slug',
        ];
    }


    protected function update(): array
    {
        return [
            'name' => 'required|unique:brands,name,' . decrypt($this->route('brand')),
            'slug' => 'required|unique:brands,slug,' . decrypt($this->route('brand')),
        ];
    }
}
