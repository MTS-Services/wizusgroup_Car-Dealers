<?php

namespace App\Http\Requests\Admin\ProductManagement;

use Illuminate\Foundation\Http\FormRequest;

class ProductInfoCatRequest extends FormRequest
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
     */   public function rules(): array
    {
        return [
            

        ]
            +
            ($this->isMethod('POST') ? $this->store() : $this->update());
    }
    protected function store(): array
    {
        return [
            'name' => 'required|unique:product_info_categories,name',
            'slug' => 'required|unique:product_info_categories,slug',
        ];
    }


    protected function update(): array
    {
        return [
            'name' => 'required|unique:product_info_categories,name,' . decrypt($this->route('product_info_category')),
            'slug' => 'required|unique:product_info_categories,slug,' . decrypt($this->route('product_info_category')),
        ];
    }
}
