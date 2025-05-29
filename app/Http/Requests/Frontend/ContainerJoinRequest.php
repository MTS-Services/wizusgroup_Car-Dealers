<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\ContainerProduct;

class ContainerJoinRequest extends FormRequest
{
    protected ?ContainerProduct $containerProduct = null;

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
            'email' => 'required|email',
            'whatsapp' => 'required|numeric',
            'quantity' => 'required|numeric|min:1|max:' . $this->maxQuantity(),
            'price' => 'required|numeric|min:' . $this->minPrice(),
            'reserve_price' => 'required|numeric|min:' . $this->minReservePrice(),
            'note' => 'nullable|string',
        ];
    }

    protected function getContainerProduct(): ContainerProduct
    {
        if ($this->containerProduct === null) {
            $containerSlug = $this->route('container_slug');
            $productSlug = $this->route('product_slug');

            $this->containerProduct = ContainerProduct::whereHas('container', function ($q) use ($containerSlug) {
                $q->where('slug', $containerSlug);
            })
                ->whereHas('product', function ($q) use ($productSlug) {
                    $q->where('slug', $productSlug);
                })
                ->with(['container', 'product']) // optional: if you need related data
                ->firstOrFail();
        }

        return $this->containerProduct;
    }

    protected function minPrice()
    {
        return $this->getContainerProduct()->price * $this->input('quantity', 1);
    }

    protected function minReservePrice()
    {
        return $this->getContainerProduct()->reserve_price * $this->input('quantity', 1);
    }

    protected function maxQuantity()
    {
        return $this->getContainerProduct()->quantity;
    }
}
