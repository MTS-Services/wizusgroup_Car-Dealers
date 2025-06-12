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
            'deadline' => 'required|date|after_or_equal:today',
            'length_m' => 'required|numeric|min:0',
            'width_m' => 'required|numeric|min:0',
            'height_m' => 'required|numeric|min:0',
            'base_cost' => 'required|numeric|min:0',
            'per_kg_cost' => 'required|numeric|min:0',
            'per_cbm_cost' => 'required|numeric|min:0',
            'max_weight_kg' => 'nullable|numeric|min:0',
            'shipping_port' => 'required|exists:shipping_locations,id',
            'destination_port' => 'required|exists:shipping_locations,id|different:shipping_port',
            'container_products.*.product_id' => 'nullable|exists:products,id',
            'container_products.*.price' => 'nullable|numeric|min:0',
            'container_products.*.reserve_price' => 'nullable|numeric|min:0',
            'departure_date' => "required|date|after_or_equal:{$this->deadline}",
            'estimated_delivery_days' => 'required|string',

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
            'slug' => 'required|unique:containers,slug,' . decrypt($this->route('container')),
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
