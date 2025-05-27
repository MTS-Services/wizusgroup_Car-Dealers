<?php

namespace App\Http\Requests\User;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class ProductReserveRequest extends FormRequest
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
            'name' => 'required|string',
            'email' => 'required|email',
            'whatsapp_number' => 'required|string',
            'reserve_price' => 'required|numeric|min:' . $this->reservePrice(),
            'note' => 'nullable|string',
        ];
    }

    protected function reservePrice()
    {
        $product = Product::where('slug', $this->route('slug'))->firstOrFail();
        return round($product->price / 2);
    }
}
