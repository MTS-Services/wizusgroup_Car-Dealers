<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\CheckoutSubmitRequest;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\AddressService;
use App\Services\Admin\Setup\CountryService;
use Illuminate\Support\Facades\DB;
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

    protected function getCart()
    {
        if (!auth()->guard('web')->check() && !session()->get('cart_session_id')) {
            return null;
        }
        $user = auth()->guard('web')->check() ? user() : null;
        $sessionId = session()->get('cart_session_id');
        return $user
            ? Cart::with('items.product')->where('user_id', $user->id)->first()
            : ($sessionId ? Cart::with('items.product')->where('session_id', $sessionId)->first() : null);
    }

    public function checkoutSubmit(CheckoutSubmitRequest $request)
    {


        try {
            $cart = $this->getCart();
            if (!$cart) {
                throw new \Exception('You have no items in your cart');
            }
            
            $sessionId = session()->get('cart_session_id');
            $user = auth()->guard('web')->check() ? user() : null;

            $orderNumber = generateOrderNumber();
            DB::transaction(function () use ($user, $sessionId, $cart, $orderNumber) {
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
                        'creater_id' => $user ? $user->id : null,
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
            session()->flash('error',  $e->getMessage());
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

    public function quantityUpdate(Request $request)
    {

        $newQuantity = $request->input('quantity');

        $orderItem = OrderItem::where('id', $request->input('item_id'))->select(['id', 'quantity'])->first();

        if (!$orderItem) {
            return response()->json([
                'status' => 'error',
                'message' => 'Order item not found.'
            ], 404);
        }

        $orderItem->quantity = $newQuantity;
        $orderItem->save();


        return response()->json([
            'status' => 'success',
            'message' => 'Quantity updated successfully.',
            'new_quantity' => $newQuantity,
            'item_id' => $orderItem->id
        ]);
    }

    public function removeItem(Request $request)
    {
        $itemId = $request->input('item_id');

        return response()->json([
            'status' => 'success',
            'message' => 'Item removed successfully.',
            'item_id' => $itemId
        ]);
    }
}
