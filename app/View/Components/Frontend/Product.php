<?php

namespace App\View\Components\Frontend;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;
use App\Models\Product as ProductModel;

class Product extends Component
{
    public ProductModel $product;
    /**
     * Create a new component instance.
     */
    public function __construct(ProductModel $product)
    {
        $this->product = $product;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.frontend.product');
    }
}
