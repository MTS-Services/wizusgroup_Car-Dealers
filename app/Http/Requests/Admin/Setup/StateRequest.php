<?php

namespace App\Http\Requests\Admin\Setup;

use Illuminate\Foundation\Http\FormRequest;

class StateRequest extends FormRequest
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
            'country_id'=> 'required|exists:countries,id',

        ]
            +
            ($this->isMethod('POST') ? $this->store() : $this->update());
    }

    protected function store(): array
    {
        return [
            'name' => 'required|unique:states,name',
            'slug' => 'required|unique:states,slug',
            'code' => 'required|unique:states,code',
        ];
    }


    protected function update(): array
    {
        return [
            'name' => 'required|unique:states,name,' . decrypt($this->route('state')),
            'slug' => 'required|unique:states,slug,' . decrypt($this->route('state')),
            'code' => 'required|unique:states,code,' . decrypt($this->route('state')),
        ];
    }
}
