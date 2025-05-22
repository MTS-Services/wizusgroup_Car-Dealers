<?php

namespace App\Http\Requests\Admin\ProductManagement;

use Illuminate\Foundation\Http\FormRequest;

class ProductInfoRequest extends FormRequest
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
            "product_info_cat_id"=> "required|exists:product_info_categories,id",
            "product_info_cat_type_id"=> "required|exists:product_info_category_types,id",
            "product_info_cat_type_feature_id"=> "nullable|exists:product_info_category_type_features,id",
            "description"=> "required|string",
        ];
    }
}
