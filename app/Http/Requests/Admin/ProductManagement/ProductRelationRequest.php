<?php

namespace App\Http\Requests\Admin\ProductManagement;

use App\Models\ProductRelation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class ProductRelationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'company_id' => 'required|integer|exists:companies,id',
            'brand_id' => 'nullable|integer|exists:brands,id',
            'model_id' => 'nullable|integer|exists:models,id',
            'category_id' => 'required|integer|exists:categories,id',
            'sub_category_id' => 'required|integer|exists:categories,id',
            'sub_child_category_id' => 'nullable|integer|exists:categories,id',
            // 'tax_class_id' => 'nullable|integer|exists:tax_classes,id',
            // 'tax_rate_id' => 'nullable|integer|exists:tax_rates,id',
        ];
    }

    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            $query = ProductRelation::query()
                ->where('product_id', $this->product_id)
                ->where('company_id', $this->company_id)
                ->where('category_id', $this->category_id)
                ->where('sub_category_id', $this->sub_category_id);

            // Handle nullable fields safely
            $this->brand_id !== null
                ? $query->where('brand_id', $this->brand_id)
                : $query->whereNull('brand_id');

            $this->model_id !== null
                ? $query->where('model_id', $this->model_id)
                : $query->whereNull('model_id');

            $this->sub_child_category_id !== null
                ? $query->where('sub_child_category_id', $this->sub_child_category_id)
                : $query->whereNull('sub_child_category_id');

            if ($query->exists()) {
                $validator->errors()->add('composite', 'This product relation already exists.');
            }
        });
    }
}
