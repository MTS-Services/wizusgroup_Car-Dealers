<?php

namespace App\Http\Requests\Admin\CMS;

use Illuminate\Foundation\Http\FormRequest;

class RegionShippingTimelineRequest extends FormRequest
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
            'min_days'    => 'required|integer|min:0',
            'max_days'    => 'required|integer|gte:min_days',
            'ports'       => 'required|string|max:255',
            'description' => 'nullable|string',
        ]
            +
            ($this->isMethod('POST') ? $this->store() : $this->update());
    }
    protected function store(): array
    {
        return [
            'region_id' => 'required|unique:region_shipping_timelines,region_id',
        ];
    }

    protected function update(): array
    {
        return [
            'region_id' => 'required|unique:region_shipping_timelines,region_id,' . decrypt($this->route('id')),
        ];
    }
}
