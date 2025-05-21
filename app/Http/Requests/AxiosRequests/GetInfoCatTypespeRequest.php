<?php

namespace App\Http\Requests\AxiosRequests;

use Illuminate\Foundation\Http\FormRequest;

class GetInfoCatTypespeRequest extends FormRequest
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
            'product_info_cat_id' => 'required|integer|exists:product_info_categories,id',
        ];
    }
}
