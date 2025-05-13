<?php

namespace App\View\Components\Frontend;

use Closure;
use Illuminate\View\Component;
use Illuminate\Support\Collection;
use Illuminate\Contracts\View\View;

class Testimonial extends Component
{
    public array|Collection $testimonial;

    public function __construct(array|Collection $testimonial)
    {
        $this->testimonial = $testimonial;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.frontend.testimonial');
    }
}
