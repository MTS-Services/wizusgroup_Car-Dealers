<?php

namespace App\Http\Requests\Admin\ProductManagement;

use Illuminate\Foundation\Http\FormRequest;

class BannerRequest extends FormRequest
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
            'start_date'=> 'nullable|date',
            'end_date'=> 'nullable|date|after:start_date',
            'url'=> 'nullable|url',
            'image'=> 'required|image|mimes:jpeg,png,jpg,webp,svg|max:2048',

        ]
            +
            ($this->isMethod('POST') ? $this->store() : $this->update());
    }

    protected function store(): array
    {
        return [
            'title' => 'required|unique:banners,title',
            'subtitle' => 'required|unique:banners,subtitle',
        ];
    }


    protected function update(): array
    {
        return [
            'title' => 'required|unique:banners,title,' . decrypt($this->route('banner')),
            'subtitle' => 'required|unique:banners,subtitle,' . decrypt($this->route('banner')),
        ];
    }
}
