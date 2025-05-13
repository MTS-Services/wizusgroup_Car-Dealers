<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
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
            'phone' => 'nullable|string',
            'country_id' => 'required|integer|exists:countries,id',
            'state_id' => 'nullable|integer|exists:states,id',
            'city_id' => 'required|integer|exists:cities,id',
            'area_id' => 'nullable|integer|exists:operation_areas,id',
            'sub_area_id' => 'nullable|integer|exists:operation_sub_areas,id',
            'address_line_1' => 'required|string',
            'address_line_2' => 'nullable|string',
            'postal_code' => 'required|string',
            'latitude' => 'nullable|string',
            'longitude' => 'nullable|string',
        ];
    }
}
