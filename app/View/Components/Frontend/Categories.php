<?php

namespace App\View\Components\Frontend;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Catagories extends Component
{

    public array|Collection $categories;
    /**
     * Create a new component instance.
     */
    public function __construct(array|Collection $categories)
    {
        $this->categories = $categories;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.frontend.catagories');
    }
}
