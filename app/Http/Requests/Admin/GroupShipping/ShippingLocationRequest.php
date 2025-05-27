<?php

namespace App\Http\Requests\Admin\GroupShipping;

use Illuminate\Foundation\Http\FormRequest;

class ShippingLocationRequest extends FormRequest
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
            'name' => 'required|string|max:255',
       ]
            +
            ($this->isMethod('POST') ? $this->store() : $this->update());
    }

    protected function store(): array
    {
        return [
            'name' => 'required|unique:shipping_locations,name',
            'slug' => 'required|unique:shipping_locations,slug',
        ];
    }


    protected function update(): array
    {
        return [
            'name' => 'required|unique:shipping_locations,name,' . decrypt($this->route('shipping_location')),
            'slug' => 'required|unique:shipping_locations,slug,' . decrypt($this->route('shipping_location')),
        ];
    }
}
