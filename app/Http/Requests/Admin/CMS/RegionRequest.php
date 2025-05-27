<?php

namespace App\Http\Requests\Admin\CMS;

use Illuminate\Foundation\Http\FormRequest;

class RegionRequest extends FormRequest
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
            'name' => 'required|unique:regions,name',
            'slug' => 'required|unique:regions,slug',
        ];
    }


    protected function update(): array
    {
        return [
            'name' => 'required|unique:regions,name,' . decrypt($this->route('region')),
            'slug' => 'required|unique:regions,slug,' . decrypt($this->route('region')),
        ];
    }
}
