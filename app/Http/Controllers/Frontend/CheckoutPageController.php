<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\AddressService;
use App\Services\Admin\Setup\CountryService;
use DB;
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
    public function checkoutSubmit(Request $request)
    {
        try {


            $user = auth()->guard('web')->check() ? user() : null;
            $sessionId = session()->get('cart_session_id');
            $cart = $user
                ? Cart::with('items.product')->where('user_id', $user->id)->first()
                : ($sessionId ? Cart::with('items.product')->where('session_id', $sessionId)->first() : null);

            if (!$cart) {
                throw new \Exception('Cart not found');
            }
            $orderNumber = generateOrderNumber();
            DB::transaction(function () use ($request, $user, $sessionId, $cart, $orderNumber) {
                // Create the order
                $orderData = [
                    'order_number' => $orderNumber,
                    'status' => Order::STATUS_INITIATED,
                ];

                if ($user) {
                    $orderData['user_id'] = $user->id;
                    $orderData['creater_id'] = $user->id;
                    $orderData['creater_type'] = get_class($user);
                } else {
                    $orderData['session_id'] = $sessionId;
                }

                $order = Order::create($orderData);

                // Create order items
                foreach ($cart->items as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item->product_id,
                        'is_dropshipping' => $item->product?->product_type == Product::PRODUCT_TYPE_DROPSHIPPING
                            ? OrderItem::DROPSHIPPING
                            : OrderItem::NOT_DROPSHIPPING,
                        'quantity' => $item->quantity,
                        'unit_price' => $item->price,
                        'sub_total' => $item->price * $item->quantity,
                        'total' => $item->price * $item->quantity,
                        'creater_id' => $user?->id,
                        'creater_type' => $user ? get_class($user) : null,
                    ]);
                }

                // Update order totals
                $order->load('items');
                $order->update([
                    'sub_total' => $order->items->sum('sub_total'),
                    'total' => $order->items->sum('total'),
                ]);

                // Clear cart
                $cart->items()->forceDelete();
                $cart->forceDelete();

                session()->flash('success', 'Order initiated successfully');
            });
            return redirect()->route('frontend.checkout', ['orderNumber' => $orderNumber]);
        } catch (\Throwable $e) {
            report($e); // Log the error
            session()->flash('error', 'Something went wrong: ' . $e->getMessage());
            return redirect()->back();
        }


    }

    public function checkout($orderNumber)
    {
        if (!Order::where('order_number', $orderNumber)->exists()) {
            abort(404);
        }
        $data['countries'] = $this->countryService->getCountrys()->active()->get();
        $data['order'] = Order::with('items.product.primaryImage')->where('order_number', $orderNumber)->first();
        return view('frontend.pages.checkout', $data);
    }
}
