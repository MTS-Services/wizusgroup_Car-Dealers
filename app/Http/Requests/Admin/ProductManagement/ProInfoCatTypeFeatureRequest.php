<?php

namespace App\Http\Requests\Admin\ProductManagement;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProInfoCatTypeFeatureRequest extends FormRequest
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
            'product_info_cat_id' => 'required|exists:product_info_categories,id',
            'product_info_cat_type_id' => 'required|exists:product_info_category_types,id',

        ]
            +
            ($this->isMethod('POST') ? $this->store() : $this->update());
    }

    protected function store(): array
    {
        return [
            'name' => [
                'required',
                Rule::unique('product_info_category_type_features')->where(
                    fn($query) =>
                    $query->where('product_info_cat_type_id', $this->product_info_cat_type_id)
                ),
            ],
            'slug' => 'required|unique:product_info_category_type_features,slug',
        ];
    }


    protected function update(): array
    {
        return [
            'name' => [
                'required',
                Rule::unique('product_info_category_type_features')
                    ->where(
                        fn($query) =>
                        $query->where('product_info_cat_type_id', $this->product_info_cat_type_id)
                    )
                    ->ignore($this->route('pro_info_cat_tf')),
            ],
            'slug' => 'required|unique:product_info_category_type_features,slug,' . decrypt($this->route('pro_info_cat_tf')),
        ];
    }
}
