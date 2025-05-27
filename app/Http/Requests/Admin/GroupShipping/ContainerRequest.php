<?php

namespace App\Http\Requests\Admin\GroupShipping;

use Illuminate\Foundation\Http\FormRequest;

class ContainerRequest extends FormRequest
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

            'sort_order' => 'nullable|integer',
            'title' => 'required|string|max:255',
            'image' => 'nullable|image',
            'deadline' => 'required|date',
            'length_cm' => 'required|numeric|min:0',
            'width_cm' => 'required|numeric|min:0',
            'height_cm' => 'required|numeric|min:0',
            'max_weight_kg' => 'required|numeric|min:0',
            'shipping_port' => 'required|exists:shipping_locations,id',
            'destination_port' => 'required|exists:shipping_locations,id|different:shipping_port',
            'container_products.*.product_id' => 'required|exists:products,id',
            'container_products.*.quantity' => 'required|numeric|min:0',
            'container_products.*.price' => 'required|numeric|min:0',
            'container_products.*.reserve_price' => 'required|numeric|min:0',
        ]
            +
            ($this->isMethod('POST') ? $this->store() : $this->update());
    }

    protected function store(): array
    {
        return [
            'slug' => 'required|unique:containers,slug',
        ];
    }


    protected function update(): array
    {
        return [
            'slug' => 'required|unique:containers,slug,' . decrypt($this->route('container')) . ',id',
        ];
    }

    public function attributes(): array
    {
        return [
            'container_products.*.product_id' => 'Product',
            'container_products.*.quantity' => 'Quantity',
            'container_products.*.price' => 'Price',
            'container_products.*.reserve_price' => 'Reserve Price',
        ];
    }
}
