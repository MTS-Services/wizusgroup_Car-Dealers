<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\Admin\Setup\CountryService;
use Illuminate\Http\Request;

class CheckoutPageController extends Controller
{
    protected CountryService $countryService;

    public function __construct(CountryService $countryService)
    {
        $this->countryService = $countryService;
    }
    public function checkout()
    {
        $data['countries'] = $this->countryService->getCountrys()->active()->get();
        return view('frontend.pages.checkout', $data);
    }
}
