<?php

namespace App\Http\Requests\AxiosRequests;

use App\Http\Requests\JsonResponceErrors;

class GetModelRequest extends JsonResponceErrors
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
            "brand_id" => "sometimes|required|exists:brands,id",
            "company_id" => "sometimes|required|exists:companies,id",
        ];
    }
}
