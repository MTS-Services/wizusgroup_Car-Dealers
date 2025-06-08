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
use Illuminate\Http\JsonResponse;
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

    public function quantityUpdate(Request $request): JsonResponse
    {
        $itemId = $request->input('item_id');
        $newQuantity = (int) $request->input('new_quantity');



        $orderItem = OrderItem::with(['order', 'product'])->where('id', $itemId)->first();
        $orderTotal = $orderItem->order->total;
        $orderSubtotal = $orderItem->order->sub_total;
        $itemTotal = $orderItem->total;
        $itemSubTotal = $orderItem->sub_total;

        if (!$orderItem) {
            return response()->json([
                'status' => 'error',
                'message' => 'Order item not found.'
            ], 404);
        }

        if ($newQuantity > $orderItem->product->quantity) {
            $newQuantity = $orderItem->product->quantity;
            return response()->json([
                'status' => 'info',
                'message' => 'Quantity limit reached.',
                'item_id' => $itemId,
                'new_quantity' => $newQuantity,
                'item_subtotal' => $itemSubTotal,
                'item_total' => $itemTotal,
                'order_subtotal' => $orderSubtotal,
                'order_total' => $orderTotal,

            ]);
        }

        // CHANGED: If new quantity is less than 1, set it to 1 and return an info message
        if ($newQuantity < 1) {
            $newQuantity = 1; // Force minimum quantity to 1
            $orderItem->quantity = $newQuantity;
            $orderItem->save(); // Save the item with quantity 1
            // Recalculate total after change

            return response()->json([
                'status' => 'info', // Changed status to 'info' as it's not an error, but an adjustment
                'message' => 'Minimum quantity for this item is 1.', // Specific message
                'item_id' => $itemId, // Return the item ID
                'new_quantity' => $newQuantity, // Return the adjusted quantity
                'item_subtotal' => $itemSubTotal, // Return the updated subtotal
                'item_total' => $itemTotal, // Return the updated subtotal
                'order_subtotal' => $orderSubtotal, // Return the updated subtotal
                'order_total' => $orderTotal,
            ]);
        }

        $orderItem->quantity = $newQuantity;
        $orderItem->sub_total = $orderItem->quantity * $orderItem->unit_price;
        $orderItem->total = $orderItem->quantity * $orderItem->unit_price;
        $orderItem->save(); // This will trigger the updating event to recalculate $item->total

        $orderItem->refresh();
        $orderItem->order()->update([
            'sub_total' => $orderItem->order->items->sum('sub_total'),
            'total' => $orderItem->order->items->sum('total'),
        ]);
        $orderItem->order->refresh();

        $orderTotal = $orderItem->order->total;
        $orderSubtotal = $orderItem->order->sub_total;
        $itemTotal = $orderItem->total;
        $itemSubTotal = $orderItem->sub_total;

        return response()->json([
            'status' => 'success',
            'message' => 'Order item quantity updated.',
            'item_id' => $itemId,
            'new_quantity' => $orderItem->quantity,
            'item_subtotal' => $itemSubTotal,
            'item_total' => $itemTotal,
            'order_subtotal' => $orderSubtotal,
            'order_total' => $orderTotal,
        ]);
    }

    /**
     * Remove item from cart.
     * This method only returns the ID of the removed item and the new cart total.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeItem(Request $request): JsonResponse
    {
        $itemId = $request->input('item_id');
        $orderItem = OrderItem::with('order')->where('id', $itemId)->first();
        $order = $orderItem->order;

        if (!$orderItem) {
            return response()->json([
                'status' => 'error',
                'message' => 'Order item not found.'
            ], 404);
        }

        $orderItem->forceDelete();
        $order->load('items');

        $order->update([
            'sub_total' => $order->items->sum('sub_total'),
            'total' => $order->items->sum('total'),
        ]);

        $orderTotal = $order->total;
        $orderSubtotal = $order->sub_total;

        return response()->json([
            'status' => 'success',
            'message' => 'Item removed from cart.',
            'removed_item_id' => $itemId,
            'order_total' => $orderTotal,
            'order_subtotal' => $orderSubtotal
        ]);
    }

    public function fetchOrderItems(Request $request): JsonResponse
    {


        $order = Order::findOrFail(decrypt($request->input('order_id')));

        if (!$order) {
            return response()->json([
                'status' => 'error',
                'message' => 'Order not found.'
            ], 404);
        }

        $orderItems = $order->items()->with('product.primaryImage', 'product.brand', 'product.model')->get();
        $orderTotal = $order->total;
        $orderSubtotal = $order->sub_total;

        return response()->json([
            'status' => 'success',
            'order_items' => $orderItems,
            'order_total' => $orderTotal,
            'order_subtotal' => $orderSubtotal
        ]);
    }




}
