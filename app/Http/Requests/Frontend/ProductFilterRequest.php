<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class ProductFilterRequest extends FormRequest
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
            "subcategory"=> "nullable|exists:categories,id",
            "brand"=> "nullable|exists:brands,id",
            "model"=> "nullable|exists:models,id",
            "year"=> "nullable",
            "start_price"=> "nullable|min:0|numeric",
            "end_price"=> "nullable|min:0|numeric",
        ];
    }
}
