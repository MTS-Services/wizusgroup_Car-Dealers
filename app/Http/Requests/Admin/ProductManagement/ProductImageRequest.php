<?php

namespace App\Http\Requests\Admin\ProductManagement;

use Illuminate\Foundation\Http\FormRequest;

class ProductImageRequest extends FormRequest
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
            "image"=> "required|image|mimes:jpeg,png,jpg,webp,svg|max:2048",
            "images.*" => "required|image|mimes:jpeg,png,jpg,webp,svg|max:2048",
            "images"=> "required|array",
        ];
    }
}
