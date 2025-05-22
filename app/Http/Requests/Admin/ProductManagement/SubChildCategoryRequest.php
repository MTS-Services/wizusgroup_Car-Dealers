<?php

namespace App\Http\Requests\Admin\ProductManagement;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class SubChildCategoryRequest extends FormRequest
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

            'meta_title' => 'nullable|string|min:20|max:60',
            'meta_description' => 'nullable|string|min:50|max:160',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'parent_id' => 'required|exists:categories,id',
            'category_id' => 'required|exists:categories,id',

        ]
            +
            ($this->isMethod('POST') ? $this->store() : $this->update());
    }

    protected function store(): array
    {
        return [
            'name' => [
                'required',
                Rule::unique('categories')->where(
                    fn($query) =>
                    $query->where('parent_id', $this->parent_id)
                ),
            ],
            'slug' => [
                'required',
                Rule::unique('categories')->where(
                    fn($query) =>
                    $query->where('parent_id', $this->parent_id)
                ),
            ],
        ];
    }


    protected function update(): array
    {
        return [
            'name' => [
                'required',
                Rule::unique('categories')
                    ->where(
                        fn($query) =>
                        $query->where('parent_id', $this->parent_id)
                    )
                    ->ignore(decrypt($this->route('sub_child_category'))),
            ],
            'slug' => [
                'required',
                Rule::unique('categories')
                    ->where(
                        fn($query) =>
                        $query->where('parent_id', $this->parent_id)
                    )
                    ->ignore(decrypt($this->route('sub_child_category'))),
            ],

        ];
    }
}
