<?php

namespace App\Http\Requests\Admin\CMS;

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
            'title' => 'required|string|min:4',
            'subtitle' => 'required|string|min:4',
            'url' => 'required|url',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ] + ($this->isMethod('POST') ? $this->store() : $this->update());
    }

    protected function store(): array
    {
        return [
            'image' => 'required',
        ];
    }

    protected function update(): array
    {
        return [
            'image' => 'nullable',
        ];
    }
}
