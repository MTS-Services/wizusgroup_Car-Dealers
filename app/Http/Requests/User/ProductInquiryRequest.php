<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class ProductInquiryRequest extends FormRequest
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
            'in_name' => 'required|string',
            'in_email' => 'required|email',
            'in_whatsapp_number' => 'required|string',
        ];
    }

    public function attributes(): array
    {
        return [
            'in_name' => 'name',
            'in_email' => 'email',
            'in_whatsapp_number' => 'WhatsApp number',
        ];
    }
}
