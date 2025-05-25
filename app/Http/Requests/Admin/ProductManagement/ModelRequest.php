<?php

namespace App\Http\Requests\Admin\ProductManagement;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ModelRequest extends FormRequest
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
            'meta_description' => 'nullable|string',
            'meta_title' => 'nullable|string',
            'image'=> 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
            'company_id' => 'required|exists:companies,id',
            'brand_id' => 'required|exists:brands,id',

        ]
            +
            ($this->isMethod('POST') ? $this->store() : $this->update());
    }

    protected function store(): array
    {
        return [
            'name' => [
                'required',
                Rule::unique('models')->where(
                    fn($query) =>
                    $query->where('brand_id', $this->brand_id)
                ),
            ],
            'slug' => 'required|unique:models,slug',
        ];
    }


    protected function update(): array
    {
        return [
            'name' => [
                'required',
                Rule::unique('models')
                    ->where(
                        fn($query) =>
                        $query->where('brand_id', $this->brand_id)
                    )
                    ->ignore(decrypt($this->route('model'))),
            ],
            'slug' => 'required|unique:models,slug,' . decrypt($this->route('model')),
        ];
    }
}
