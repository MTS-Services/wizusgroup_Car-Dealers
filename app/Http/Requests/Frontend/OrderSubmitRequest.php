<?php

namespace App\Http\Requests\Frontend;

use App\Models\AuthBaseModel;
use App\Models\Order;
use App\Models\PersonalInformation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class OrderSubmitRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    protected array $rules = [];
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
        if (!auth()->guard('web')->check()) {
            $this->rules += [
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'password' => 'required|string|min:8|confirmed',
                'email' => 'required|string|email|max:255|unique:users',
                'whatsapp' => 'required|numeric',
                'gender' =>
                    'required|integer|',
                Rule::in([
                    AuthBaseModel::GENDER_MALE,
                    AuthBaseModel::GENDER_FEMALE,
                    AuthBaseModel::GENDER_OTHERS,
                ]),
                'language' => 'required|integer',
                Rule::in([
                    PersonalInformation::LANGUAGE_ENGLISH,
                    PersonalInformation::LANGUAGE_FRENCH,
                    PersonalInformation::LANGUAGE_ARGENTINE,
                ]),
            ];
        }

        $this->rules += [
            'name' => 'required|string|max:255',
            'd_email' => 'required|string|email|max:255',
            'phone' => 'required|numeric',
            'country_id' => 'required|integer|exists:countries,id',
            'state_id' => 'required|integer|exists:states,id',
            'city_id' => 'required|integer|exists:cities,id',
            'address_line_1' => 'required|string',
            'postal_code' => 'required|string',
            'shipping_port' => 'required|exists:shipping_locations,id',
            'destination_port' => 'required|exists:shipping_locations,id|different:shipping_port',
            'container_type' => 'required|integer',
            Rule::in([
                Order::GROUP_SHIPPING,
                Order::FULL_CONTAINER,
            ]),
        ];



        return $this->rules + ($this->isMethod('POST') ? $this->store() : $this->update());
    }

    protected function store(): array
    {
        return [

        ];


    }


    protected function update(): array
    {
        return [

        ];
    }
}
