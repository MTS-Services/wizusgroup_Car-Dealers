<?php

namespace App\Http\Requests\Admin\ProductManagement;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name' => 'required|string|min:3',
            'grade' => 'nullable|string',
            'body' => 'nullable|string',
            'first_registration' => 'nullable|string',
            'type' => 'nullable|string',
            'displacement' => 'nullable|string',
            'capacity' => 'nullable|string',
            'specification_no' => 'nullable|string',
            'classification_no' => 'nullable|string',
            'chassis_no' => 'nullable|string',
            'serial_no' => 'nullable|string',
            'price' => 'required|numeric',
            'cost_price' => 'required|numeric',
            'sale_price' => 'required|numeric',
            'quantity' => 'required|numeric|min:0',
            'engine_type' => 'nullable|string',
            'fuel_type' => 'nullable|string',
            'color' => 'nullable|string',
            'milage' => 'nullable|string',
            'odometer_replacement' => 'nullable|string',
            'streeing_wheel' => 'nullable|string',
            'transmission' => 'nullable|string',
            'drive_system' => 'nullable|string',
            'supplier_id' => 'nullable|integer|exists:suppliers,id',
            'meta_title' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|array',
            'meta_keywords.*' => 'nullable|string',
            'remarks' => 'nullable|string',
            'description' => 'nullable|string',
            'product_type' => 'required|integer',
        ] + ($this->isMethod('POST') ? $this->store() : $this->update());
    }

    protected function store(): array
    {
        return [
            'slug' => 'required|string|unique:products,slug',
            'sku' => 'required|string|unique:products,sku',
            'stock_no' => 'required|string|unique:products,stock_no',
        ];
    }
    protected function update(): array
    {
        return [
            'slug' => 'required|string|unique:products,slug,' . decrypt($this->route('product')),
            'sku' => 'required|string|unique:products,sku,' . decrypt($this->route('product')),
            'stock_no' => 'required|string|unique:products,stock_no,' . decrypt($this->route('product')),
        ];
    }
}
