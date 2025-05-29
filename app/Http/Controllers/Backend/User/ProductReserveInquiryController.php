<?php

namespace App\Http\Controllers\Backend\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ProductInquiryRequest;
use App\Http\Requests\User\ProductReserveRequest;
use App\Mail\ReserveMail;
use App\Models\Product;
use App\Models\ProductInquiry;
use App\Models\ProductReserve;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

class ProductReserveInquiryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    // it will be change to redirect Whatsapp
    protected function RedirectPath($slug)
    {
        return redirect()->back()->withInput(['slug' => $slug]);
    }

    public function reserveStore(ProductReserveRequest $request, string $slug)
    {
        $validated = $request->validated();
        $validated['product_id'] = Product::where('slug', $slug)->firstOrFail()->id;
        $validated['user_id'] = user()->id;
        $reserve =ProductReserve::create($validated);
        Mail::to('oasiffre@gmail.com')->send(new ReserveMail($reserve));
        session()->flash('success', 'Product reserve successfully!');
        return $this->RedirectPath($slug);
    }
    public function inquiryStore(ProductInquiryRequest $request, string $slug)
    {
        $validated = $request->validated();
        $validated['product_id'] = Product::where('slug', $slug)->firstOrFail()->id;
        $validated['user_id'] = user()->id;
        ProductInquiry::create($validated);
        session()->flash('success', 'Product inquiry successfully!');
        return $this->RedirectPath($slug);
    }
}
