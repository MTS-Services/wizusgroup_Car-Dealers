<?php

namespace App\Http\Requests\Admin\Setup;

use Illuminate\Foundation\Http\FormRequest;

class OperationSubAreaRequest extends FormRequest
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
            'country' => 'required|exists:countries,id',
            'state' => 'nullable|exists:states,id',
            'city' => 'required|exists:cities,id',
            'operation_area' => 'required|exists:operation_areas,id',

        ]
            +
            ($this->isMethod('POST') ? $this->store() : $this->update());
    }

    protected function store(): array
    {
        return [
            'name' => 'required|unique:operation_sub_areas,name',
            'slug' => 'required|unique:operation_sub_areas,slug',
        ];
    }


    protected function update(): array
    {
        return [
            'name' => 'required|unique:operation_sub_areas,name,' . decrypt($this->route('operation_sub_area')),
            'slug' => 'required|unique:operation_sub_areas,slug,' . decrypt($this->route('operation_sub_area')),
        ];
    }
}
