<?php

namespace App\Http\Requests\Admin\Setup;

use Illuminate\Foundation\Http\FormRequest;

class CountryRequest extends FormRequest
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

        ]
            +
            ($this->isMethod('POST') ? $this->store() : $this->update());
    }

    protected function store(): array
    {
        return [
            'name' => 'required|unique:countries,name',
            'slug' => 'required|unique:countries,slug',
        ];
    }


    protected function update(): array
    {
        return [
            'name' => 'required|unique:countries,name,' . decrypt($this->route('country')),
            'slug' => 'required|unique:countries,slug,' . decrypt($this->route('country')),
        ];
    }
}
