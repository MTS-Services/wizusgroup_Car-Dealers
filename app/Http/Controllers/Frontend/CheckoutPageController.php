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
use Exception;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class CheckoutPageController extends Controller
{
    protected CountryService $countryService;
    protected AddressService $addressService;

    public function __construct(CountryService $countryService, AddressService $addressService)
    {
        $this->countryService = $countryService;
        $this->addressService = $addressService;
    }

    /**
     * Get cart for current user or session
     *
     * @return Cart|null
     */
    protected function getCart(): ?Cart
    {
        try {
            if (!auth()->guard('web')->check() && !session()->get('cart_session_id')) {
                return null;
            }

            $user = auth()->guard('web')->check() ? user() : null;
            $sessionId = session()->get('cart_session_id');

            return $user
                ? Cart::with('items.product')->where('user_id', $user->id)->first()
                : ($sessionId ? Cart::with('items.product')->where('session_id', $sessionId)->first() : null);

        } catch (Exception $e) {
            Log::error('Error getting cart: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Submit checkout from cart
     *
     * @param CheckoutSubmitRequest $request
     * @return RedirectResponse
     */
    public function checkoutSubmit(CheckoutSubmitRequest $request): RedirectResponse
    {
        try {
            $cart = $this->getCart();

            if (!$cart || $cart->items->isEmpty()) {
                session()->flash('error', 'You have no items in your cart');
                return redirect()->back();
            }

            // Check stock availability for all items
            foreach ($cart->items as $item) {
                if ($item->quantity > $item->product->quantity) {
                    session()->flash('error', "Insufficient stock for {$item->product->name}");
                    return redirect()->back();
                }
            }

            $orderNumber = generateOrderNumber();

            DB::transaction(function () use ($cart, $orderNumber) {
                $user = auth()->guard('web')->check() ? user() : null;
                $sessionId = session()->get('cart_session_id');

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
                $orderItems = [];
                foreach ($cart->items as $item) {
                    $orderItems[] = [
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
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

                // Bulk insert order items for better performance
                OrderItem::insert($orderItems);

                // Update order totals
                $order->load('items');
                $order->update([
                    'sub_total' => $order->items->sum('sub_total'),
                    'total' => $order->items->sum('total'),
                ]);

                // Clear cart
                $cart->items()->forceDelete();
                $cart->forceDelete();
            });

            session()->flash('success', 'Order checkout successfully');
            return redirect()->route('frontend.checkout', ['orderNumber' => $orderNumber]);

        } catch (Exception $e) {
            Log::error('Error in checkout submit: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'user_id' => auth()->id(),
            ]);

            session()->flash('error', 'Something went wrong during checkout. Please try again.');
            return redirect()->back();
        }
    }

    /**
     * Create order for single product
     *
     * @param string $slug
     * @return RedirectResponse
     */
    public function singleOrder(string $slug): RedirectResponse
    {
        try {
            $product = Product::where('slug', $slug)->first();

            if (!$product) {
                session()->flash('error', 'Product not found');
                return redirect()->back();
            }

            if ($product->quantity < 1) {
                session()->flash('error', 'Product is out of stock');
                return redirect()->back();
            }

            $orderNumber = generateOrderNumber();

            DB::transaction(function () use ($product, $orderNumber) {
                $user = auth()->guard('web')->check() ? user() : null;
                $sessionId = session()->has('cart_session_id')
                    ? session()->get('cart_session_id')
                    : Session::getId();

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

                // Create order item
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
                $order->update([
                    'sub_total' => $product->price,
                    'total' => $product->price,
                ]);

                session()->put('cart_session_id', $sessionId);
            });

            session()->flash('success', 'Order checkout successfully');
            return redirect()->route('frontend.checkout', ['orderNumber' => $orderNumber]);

        } catch (Exception $e) {
            Log::error('Error in single order: ' . $e->getMessage(), [
                'slug' => $slug,
                'trace' => $e->getTraceAsString(),
                'user_id' => auth()->id(),
            ]);

            session()->flash('error', 'Something went wrong. Please try again.');
            return redirect()->back();
        }
    }

    /**
     * Show checkout page
     *
     * @param string $orderNumber
     * @return View
     */
    public function checkout(string $orderNumber): View
    {
        if (!Order::where('order_number', $orderNumber)->exists()) {
            abort(404, 'Order not found');
        }

        $data = [
            'shipping_locations' => ShippingLocation::active()->orderBy('name')->get(),
            'countries' => $this->countryService->getCountrys()->active()->get(),
            'order' => Order::with('items.product.primaryImage')->where('order_number', $orderNumber)->first(),
        ];

        return view('frontend.pages.checkout', $data);
    }

    /**
     * Update order item quantity
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function quantityUpdate(Request $request): JsonResponse
    {
        try {
            // Validate request
            $validated = $request->validate([
                'item_id' => 'required|integer|exists:order_items,id',
                'new_quantity' => 'required|integer|min:1'
            ]);

            return DB::transaction(function () use ($validated) {
                $orderItem = OrderItem::with(['order', 'product'])
                    ->where('id', $validated['item_id'])
                    ->first();

                if (!$orderItem) {
                    return $this->errorResponse('Order item not found', 404);
                }

                $newQuantity = $validated['new_quantity'];

                // Check stock availability
                if ($newQuantity > $orderItem->product->quantity) {
                    return response()->json([
                        'status' => 'info',
                        'message' => 'Quantity limit reached.',
                        'item_id' => $validated['item_id'],
                        'new_quantity' => $orderItem->product->quantity,
                        'item_subtotal' => $orderItem->sub_total,
                        'item_total' => $orderItem->total,
                        'order_subtotal' => $orderItem->order->sub_total,
                        'order_total' => $orderItem->order->total,
                    ]);
                }

                // Enforce minimum quantity of 1
                if ($newQuantity < 1) {
                    $newQuantity = 1;
                }

                // Update order item
                $orderItem->update([
                    'quantity' => $newQuantity,
                    'sub_total' => $newQuantity * $orderItem->unit_price,
                    'total' => $newQuantity * $orderItem->unit_price,
                ]);

                // Update order totals
                $orderItem->order()->update([
                    'sub_total' => $orderItem->order->items->sum('sub_total'),
                    'total' => $orderItem->order->items->sum('total'),
                ]);

                // Refresh models to get updated values
                $orderItem->refresh();
                $orderItem->order->refresh();

                return $this->successResponse([
                    'message' => $newQuantity === 1 && $validated['new_quantity'] < 1
                        ? 'Minimum quantity for this item is 1.'
                        : 'Order item quantity updated.',
                    'item_id' => $validated['item_id'],
                    'new_quantity' => $orderItem->quantity,
                    'item_subtotal' => $orderItem->sub_total,
                    'item_total' => $orderItem->total,
                    'order_subtotal' => $orderItem->order->sub_total,
                    'order_total' => $orderItem->order->total,
                ], $newQuantity === 1 && $validated['new_quantity'] < 1 ? 'info' : 'success');
            });

        } catch (ValidationException $e) {
            return $this->errorResponse('Invalid input data', 422, $e->errors());
        } catch (Exception $e) {
            Log::error('Error updating order quantity: ' . $e->getMessage(), [
                'item_id' => $request->item_id ?? null,
                'new_quantity' => $request->new_quantity ?? null,
                'trace' => $e->getTraceAsString()
            ]);

            return $this->errorResponse('Failed to update quantity');
        }
    }

    /**
     * Remove item from order
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function removeItem(Request $request): JsonResponse
    {
        try {
            // Validate request
            $validated = $request->validate([
                'item_id' => 'required|integer|exists:order_items,id'
            ]);

            return DB::transaction(function () use ($validated) {
                $orderItem = OrderItem::with('order')
                    ->where('id', $validated['item_id'])
                    ->first();

                if (!$orderItem) {
                    return $this->errorResponse('Order item not found', 404);
                }

                $order = $orderItem->order;
                $orderItem->forceDelete();

                // Update order totals
                $order->load('items');
                $order->update([
                    'sub_total' => $order->items->sum('sub_total'),
                    'total' => $order->items->sum('total'),
                ]);

                return $this->successResponse([
                    'message' => 'Item removed from order.',
                    'removed_item_id' => $validated['item_id'],
                    'order_total' => $order->total,
                    'order_subtotal' => $order->sub_total,
                ]);
            });

        } catch (ValidationException $e) {
            return $this->errorResponse('Invalid input data', 422, $e->errors());
        } catch (Exception $e) {
            Log::error('Error removing order item: ' . $e->getMessage(), [
                'item_id' => $request->item_id ?? null,
                'trace' => $e->getTraceAsString()
            ]);

            return $this->errorResponse('Failed to remove item');
        }
    }

    /**
     * Fetch order items
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function fetchOrderItems(Request $request): JsonResponse
    {
        try {
            // Validate request
            $validated = $request->validate([
                'order_id' => 'required|string'
            ]);

            try {
                $orderId = decrypt($validated['order_id']);
            } catch (DecryptException $e) {
                return $this->errorResponse('Invalid order ID', 400);
            }

            $order = Order::with(['items.product.primaryImage', 'items.product.brand', 'items.product.model'])
                ->find($orderId);

            if (!$order) {
                return $this->errorResponse('Order not found', 404);
            }

            return $this->successResponse([
                'order_items' => $order->items,
                'order_total' => $order->total,
                'order_subtotal' => $order->sub_total,
            ]);

        } catch (ValidationException $e) {
            return $this->errorResponse('Invalid input data', 422, $e->errors());
        } catch (Exception $e) {
            Log::error('Error fetching order items: ' . $e->getMessage(), [
                'order_id' => $request->order_id ?? null,
                'trace' => $e->getTraceAsString()
            ]);

            return $this->errorResponse('Failed to fetch order items');
        }
    }

    /**
     * Helper method to return success response
     *
     * @param array $data
     * @param string $status
     * @return JsonResponse
     */
    protected function successResponse(array $data, string $status = 'success'): JsonResponse
    {
        return response()->json(array_merge(['status' => $status], $data));
    }

    /**
     * Helper method to return error response
     *
     * @param string $message
     * @param int $statusCode
     * @param array|null $errors
     * @return JsonResponse
     */
    protected function errorResponse(string $message, int $statusCode = 500, ?array $errors = null): JsonResponse
    {
        $response = [
            'status' => 'error',
            'message' => $message
        ];

        if ($errors) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $statusCode);
    }
}
