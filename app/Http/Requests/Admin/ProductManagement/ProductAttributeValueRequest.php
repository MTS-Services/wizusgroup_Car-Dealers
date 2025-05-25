<?php

namespace App\Http\Requests\Admin\ProductManagement;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductAttributeValueRequest extends FormRequest
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
            'product_id' => 'required|exists:products,id',
            'product_attribute_id' => 'required|exists:product_attributes,id',
        ] + ($this->isMethod('POST') ? $this->store() : $this->update());
    }

    protected function store(): array
    {
        return [
            'value' => [
                Rule::unique('product_attribute_values')
                    ->where(fn($query) => $query->where('product_attribute_id', $this->input('product_attribute_id')))
            ],
        ];
    }

    protected function update(): array
    {
        return [
            'value' => [
                Rule::unique('product_attribute_values')
                    ->ignore(decrypt($this->route('product_attr_value')))
                    ->where(fn($query) => $query->where('product_attribute_id', $this->input('product_attribute_id')))
            ],
        ];
    }
}
