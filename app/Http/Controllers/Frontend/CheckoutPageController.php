<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\AddressService;
use App\Services\Admin\Setup\CountryService;
use Illuminate\Http\Request;

class CheckoutPageController extends Controller
{
    protected CountryService $countryService;
    protected AddressService $addressService;

    public function __construct(CountryService $countryService, AddressService $addressService)
    {
        $this->countryService = $countryService;
        $this->addressService = $addressService;
    }
    public function checkout()
    {
        $data['countries'] = $this->countryService->getCountrys()->active()->get();
        return view('frontend.pages.checkout', $data);
    }
}
