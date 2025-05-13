<?php

namespace App\Http\Requests\Admin\Setup;

use Illuminate\Foundation\Http\FormRequest;

class CityRequest extends FormRequest
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
            'country'=> 'required|exists:countries,id',
            'state'=> 'nullable|exists:states,id',

        ]
            +
            ($this->isMethod('POST') ? $this->store() : $this->update());
    }

    protected function store(): array
    {
        return [
            'name' => 'required|unique:cities,name',
            'slug' => 'required|unique:cities,slug',
        ];
    }


    protected function update(): array
    {
        return [
            'name' => 'required|unique:cities,name,' . decrypt($this->route('city')),
            'slug' => 'required|unique:cities,slug,' . decrypt($this->route('city')),
        ];
    }
}
