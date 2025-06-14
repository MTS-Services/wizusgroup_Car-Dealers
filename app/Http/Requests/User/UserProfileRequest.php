<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserProfileRequest extends FormRequest
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
        // dd($this->all());
        return [
            'first_name' => 'required|string|min:3',
            'last_name' => 'required|string|min:3',
            'username' => 'nullable|string|min:3',  
            // 'email' => 'required|email|unique:users,email,',
            'phone' => 'nullable|string|size:11',
            'phone_2' => 'nullable|string|size:11',
            'company_name' => 'nullable|string|min:3',
            'occupation' => 'nullable|string|min:3',
            'image'=> 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
            'gender' => 'nullable',
            'dob' => 'nullable|date',
            'language' => 'nullable',
            'father_name' => 'nullable|string|min:3',
            'mother_name' => 'nullable|string|min:3',
            'emergency_phone' => 'nullable|string|min:3',
            'nationality' => 'nullable|string|min:3',
            'bio' => 'nullable|string|min:3',
            'business_type' => 'nullable',
            'business_name' => 'nullable',
            'business_information' => 'nullable|string|min:3',
            'business_line' => 'nullable',
            'receive_promotion_email' => 'nullable',
            'how_know' => 'nullable',
            'how_know_detail' => 'nullable',
            'id_registration_info' => 'nullable',
            'dealer_registration_permit' => 'nullable',

        ];
    }
}
