<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\CheckoutSubmitRequest;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ShippingLocation;
use App\Services\AddressService;
use App\Services\Admin\Setup\CountryService;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

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

                session()->flash('success', 'Order checkout successfully');
            });
            return redirect()->route('frontend.checkout', ['orderNumber' => $orderNumber]);
        } catch (\Throwable $e) {
            report($e); // Log the error
            session()->flash('error', $e->getMessage());
            return redirect()->back();
        }
    }

    public function singleOrder($slug)
    {

        try {
            $user = auth()->guard('web')->check() ? user() : null;
            $sessionId = session()->has('cart_session_id') ? session()->get('cart_session_id') : Session::getId();
            $orderNumber = generateOrderNumber();
            $product = Product::where('slug', $slug)->first();
            if (!$product) {
                throw new \Exception('Product not found');
            }
            DB::transaction(function () use ($user, $sessionId, $orderNumber, $product) {
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
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'is_dropshipping' => $product?->product_type == Product::PRODUCT_TYPE_DROPSHIPPING
                        ? OrderItem::DROPSHIPPING
                        : OrderItem::NOT_DROPSHIPPING,
                    'quantity' => 1,
                    'unit_price' => $product->price,
                    'sub_total' => $product->price,
                    'total' => $product->price,
                    'creater_id' => $user ? $user->id : null,
                    'creater_type' => $user ? get_class($user) : null,
                ]);


                // Update order totals
                $order->load('items');
                $order->update([
                    'sub_total' => $order->items->sum('sub_total'),
                    'total' => $order->items->sum('total'),
                ]);
                session()->put('cart_session_id', $sessionId);
                session()->flash('success', 'Order checkout successfully');
            });
            return redirect()->route('frontend.checkout', ['orderNumber' => $orderNumber]);
        } catch (\Throwable $e) {
            report($e); // Log the error
            session()->flash('error', $e->getMessage());
            return redirect()->back();

        }
    }

    public function checkout($orderNumber)
    {
        if (!Order::where('order_number', $orderNumber)->exists()) {
            abort(404);
        }
        $data['shipping_locations'] = ShippingLocation::active()->orderBy('name')->get();
        $data['countries'] = $this->countryService->getCountrys()->active()->get();
        $data['order'] = Order::with('items.product.primaryImage')->where('order_number', $orderNumber)->first();
        return view('frontend.pages.checkout', $data);
    }

    public function quantityUpdate(Request $request)
    {
        $request->validate([
            'item_id' => 'required|integer|exists:order_items,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $newQuantity = (int) $request->input('quantity');
        $orderItem = OrderItem::with(['product', 'order.items'])->where('id', $request->input('item_id'))->first();

        if (!$orderItem) {
            return response()->json([
                'status' => 'error',
                'message' => 'Order item not found.'
            ], 404);
        }

        // Check if requested quantity exceeds available stock
        if ($newQuantity > $orderItem->product->quantity) {
            $newQuantity = $orderItem->product->quantity;

            // Update with maximum allowed quantity
            $orderItem->update([
                'quantity' => $newQuantity,
                'sub_total' => $orderItem->unit_price * $newQuantity,
                'total' => $orderItem->unit_price * $newQuantity,
            ]);

            // Refresh the order relationship to get updated totals
            $orderItem->order->refresh();

            // Recalculate order totals
            $orderSubTotal = $orderItem->order->items->sum('sub_total');
            $orderTotal = $orderItem->order->items->sum('total');

            $orderItem->order->update([
                'sub_total' => $orderSubTotal,
                'total' => $orderTotal,
            ]);

            return response()->json([
                'status' => 'info',
                'message' => 'Quantity limit reached. Maximum available quantity applied.',
                'item_id' => $request->input('item_id'),
                'quantity' => $newQuantity,
                'item_subtotal' => $orderItem->sub_total,
                'order_subtotal' => $orderSubTotal,
                'order_total' => $orderTotal,
            ]);
        }

        // Don't allow quantity to go below 1
        if ($newQuantity < 1) {
            return response()->json([
                'status' => 'error',
                'message' => 'Quantity cannot be less than 1.'
            ], 400);
        }

        try {
            DB::transaction(function () use ($orderItem, $newQuantity) {
                // Update order item
                $orderItem->update([
                    'quantity' => $newQuantity,
                    'sub_total' => $orderItem->unit_price * $newQuantity,
                    'total' => $orderItem->unit_price * $newQuantity,
                ]);

                // Refresh the order relationship to get updated items
                $orderItem->order->refresh();

                // Recalculate order totals
                $orderSubTotal = $orderItem->order->items->sum('sub_total');
                $orderTotal = $orderItem->order->items->sum('total');

                // Update order totals
                $orderItem->order->update([
                    'sub_total' => $orderSubTotal,
                    'total' => $orderTotal,
                ]);
            });

            // Refresh to get latest data
            $orderItem->refresh();

            return response()->json([
                'status' => 'success',
                'message' => 'Quantity updated successfully.',
                'quantity' => $newQuantity,
                'item_subtotal' => $orderItem->sub_total,
                'order_subtotal' => $orderItem->order->sub_total,
                'order_total' => $orderItem->order->total,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update quantity. Please try again.'
            ], 500);
        }
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
