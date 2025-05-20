<?php

namespace App\Http\Requests\Admin\ProductManagement;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BrandRequest extends FormRequest
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
            'company_id' => 'required|exists:companies,id',
            'description' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'meta_title' => 'nullable|string',
            'image'=> 'nullable',

        ]
            +
            ($this->isMethod('POST') ? $this->store() : $this->update());
    }

    protected function store(): array
    {
        return [
            'name' => [
                'required',
                Rule::unique('brands')->where(
                    fn($query) =>
                    $query->where('company_id', $this->company_id)
                ),
            ],
            'slug' => 'required|unique:brands,slug',
        ];
    }


    protected function update(): array
    {
        return [
            'name' => [
                'required',
                Rule::unique('brands')
                    ->where(
                        fn($query) =>
                        $query->where('company_id', $this->company_id)
                    )
                    ->ignore(decrypt($this->route('brand'))),
            ],
            'slug' => 'required|unique:brands,slug,' . decrypt($this->route('brand')),
        ];
    }
}
