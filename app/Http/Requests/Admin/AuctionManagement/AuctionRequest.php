<?php

namespace App\Http\Requests\Admin\AuctionManagement;

use Illuminate\Foundation\Http\FormRequest;

class AuctionRequest extends FormRequest
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
            'title' => 'required|string',
            'product_id' => 'required|integer|exists:products,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'start_price' => 'required|numeric|min:0',
            'reserve_price' => 'required|numeric|min:0',
            'status' => 'required|integer',
            'description' => 'nullable|string',
            'meta_title' => 'nullable|string|min:20|max:60',
            'meta_description' => 'nullable|string|min:50|max:160',
        ] + ($this->isMethod('POST') ? $this->store() : $this->update());
    }

    protected function store(): array
    {
        return [
            'slug' => 'required|string|unique:auctions,slug',
        ];
    }

    public function update(): array
    {
        return [
            'slug' => 'required|string|unique:auctions,slug,' . decrypt($this->route('auction')),
        ];
    }
}
