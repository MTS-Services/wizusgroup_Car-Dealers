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
            "product_info_cat_id" => "required|exists:product_info_categories,id",
            "description" => "required|string",
            "file" => "nullable|file|mimes:pdf,doc,docx,xls,xlsx,txt,zip|max:2048",
        ];
    }
}
