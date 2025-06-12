<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\AddToCartRequest;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Services\Admin\ProductManagement\ProductService;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class CartPageController extends Controller
{
    protected ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Shows the cart page, with all cart items.
     *
     * @return View
     */
    public function cart(): View
    {
        return view('frontend.pages.cart');
    }

    /**
     * Fetches all cart items for initial sidebar rendering.
     * This method is used for the initial load, not for subsequent updates.
     *
     * @return JsonResponse
     */
    public function fetchCartItems(): JsonResponse
    {
        try {
            $cart = $this->getOrUpdateCart();

            if (!$cart) {
                return $this->successResponse([
                    'cart_items' => [],
                    'cart_total' => 0,
                ]);
            }

            $cartItems = $cart->items()
                ->with(['product.primaryImage', 'product.brand', 'product.model'])
                ->get();

            $cartTotal = $this->calculateCartTotal($cart);

            return $this->successResponse([
                'cart_items' => $cartItems,
                'cart_total' => $cartTotal,
            ]);

        } catch (Exception $e) {
            Log::error('Error fetching cart items: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return $this->errorResponse('Failed to fetch cart items');
        }
    }

    /**
     * Adds a product to the cart or informs if already exists.
     * Returns details of the added/existing item and the updated cart total.
     *
     * @param AddToCartRequest $request
     * @return JsonResponse
     */
    public function addCart(AddToCartRequest $request): JsonResponse
    {
        try {
            return DB::transaction(function () use ($request) {
                $product = Product::findOrFail($request->product_id);

                // Check if product is available
                if ($product->quantity < 1) {
                    return $this->errorResponse('Product is out of stock');
                }

                $cart = $this->getOrCreateCart();
                $cart->load('items');

                $cartItem = $cart->items()->where('product_id', $product->id)->first();

                if ($cartItem) {
                    return response()->json([
                        'status' => 'info',
                        'message' => 'This product is already in your cart.',
                        'cart_item' => $cartItem->load(['product.primaryImage', 'product.brand', 'product.model']),
                        'cart_total' => $this->calculateCartTotal($cart),
                    ]);
                }

                $cartItem = CartItem::create([
                    'product_id' => $product->id,
                    'quantity' => 1,
                    'price' => $product->price,
                    'cart_id' => $cart->id
                ]);

                $cartItem->load(['product.primaryImage', 'product.brand', 'product.model']);

                return $this->successResponse([
                    'message' => 'Product added to cart successfully.',
                    'cart_item' => $cartItem,
                    'cart_total' => $this->calculateCartTotal($cart),
                ]);
            });

        } catch (Exception $e) {
            Log::error('Error adding product to cart: ' . $e->getMessage(), [
                'product_id' => $request->product_id ?? null,
                'trace' => $e->getTraceAsString()
            ]);

            return $this->errorResponse('Failed to add product to cart');
        }
    }

    /**
     * Update cart item quantity.
     * This method only returns the updated item's subtotal and the new cart total.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function updateCartQuantity(Request $request): JsonResponse
    {
        try {
            // Validate request
            $validated = $request->validate([
                'item_id' => 'required|integer|exists:cart_items,id',
                'new_quantity' => 'required|integer|min:1'
            ]);

            return DB::transaction(function () use ($validated) {
                $cartItem = CartItem::with(['cart', 'product'])
                    ->where('id', $validated['item_id'])
                    ->first();

                if (!$cartItem) {
                    return $this->errorResponse('Cart item not found', 404);
                }

                $newQuantity = $validated['new_quantity'];

                // Check stock availability
                if ($newQuantity > $cartItem->product->quantity) {
                    $newQuantity = $cartItem->product->quantity;
                    $cartItem->quantity = $newQuantity;
                    $cartItem->save();

                    return response()->json([
                        'status' => 'info',
                        'message' => 'Quantity limit reached.',
                        'item_id' => $validated['item_id'],
                        'new_quantity' => $newQuantity,
                        'item_subtotal' => $cartItem->total,
                        'cart_total' => $this->calculateCartTotal($cartItem->cart),
                    ]);
                }

                // Enforce minimum quantity of 1
                if ($newQuantity < 1) {
                    $newQuantity = 1;
                }

                $cartItem->quantity = $newQuantity;
                $cartItem->save();

                return $this->successResponse([
                    'message' => $newQuantity === 1 && $validated['new_quantity'] < 1
                        ? 'Minimum quantity for this item is 1.'
                        : 'Cart item quantity updated.',
                    'item_id' => $validated['item_id'],
                    'new_quantity' => $cartItem->quantity,
                    'item_subtotal' => $cartItem->total,
                    'cart_total' => $this->calculateCartTotal($cartItem->cart),
                ], $newQuantity === 1 && $validated['new_quantity'] < 1 ? 'info' : 'success');
            });

        } catch (ValidationException $e) {
            return $this->errorResponse('Invalid input data', 422, $e->errors());
        } catch (Exception $e) {
            Log::error('Error updating cart quantity: ' . $e->getMessage(), [
                'item_id' => $request->item_id ?? null,
                'new_quantity' => $request->new_quantity ?? null,
                'trace' => $e->getTraceAsString()
            ]);

            return $this->errorResponse('Failed to update cart quantity');
        }
    }

    /**
     * Remove item from cart.
     * This method only returns the ID of the removed item and the new cart total.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function removeCart(Request $request): JsonResponse
    {
        try {
            // Validate request
            $validated = $request->validate([
                'item_id' => 'required|integer|exists:cart_items,id'
            ]);

            return DB::transaction(function () use ($validated) {
                $cartItem = CartItem::with('cart')
                    ->where('id', $validated['item_id'])
                    ->first();

                if (!$cartItem) {
                    return $this->errorResponse('Cart item not found', 404);
                }

                $cart = $cartItem->cart;
                $cartItem->forceDelete();

                return $this->successResponse([
                    'message' => 'Item removed from cart.',
                    'removed_item_id' => $validated['item_id'],
                    'cart_total' => $this->calculateCartTotal($cart),
                ]);
            });

        } catch (ValidationException $e) {
            return $this->errorResponse('Invalid input data', 422, $e->errors());
        } catch (Exception $e) {
            Log::error('Error removing cart item: ' . $e->getMessage(), [
                'item_id' => $request->item_id ?? null,
                'trace' => $e->getTraceAsString()
            ]);

            return $this->errorResponse('Failed to remove item from cart');
        }
    }

    /**
     * Helper method to get or update the appropriate cart.
     *
     * @return Cart|null
     */
    protected function getOrUpdateCart(): ?Cart
    {
        try {
            $sessionId = Session::getId();

            if (Auth::guard('web')->check()) {
                $userId = user()->id;
                $cart = Cart::where('user_id', $userId)->first();

                if ($cart && $cart->session_id !== $sessionId) {
                    $cart->update(['session_id' => $sessionId]);
                }
            } else {
                $cartSessionId = session('cart_session_id');

                if ($cartSessionId) {
                    $cart = Cart::where('session_id', $cartSessionId)->first();

                    if ($cart && $cart->session_id !== $sessionId) {
                        $cart->update(['session_id' => $sessionId]);
                    }
                }
            }

            if (isset($cart)) {
                session()->put('cart_session_id', $cart->session_id);
                return $cart;
            }

            return null;

        } catch (Exception $e) {
            Log::error('Error getting/updating cart: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Helper method to get or create the appropriate cart.
     *
     * @return Cart
     */
    protected function getOrCreateCart(): Cart
    {
        try {
            $sessionId = Session::getId();

            if (Auth::guard('web')->check()) {
                $userId = user()->id;
                $cart = Cart::updateOrCreate(
                    ['user_id' => $userId],
                    ['session_id' => $sessionId]
                );
            } else {
                $cartSessionId = session('cart_session_id');

                if ($cartSessionId) {
                    $cart = Cart::where('session_id', $cartSessionId)->first();

                    if ($cart) {
                        if ($cart->session_id !== $sessionId) {
                            $cart->update(['session_id' => $sessionId]);
                        }
                    } else {
                        $cart = Cart::create(['session_id' => $sessionId]);
                    }
                } else {
                    $cart = Cart::create(['session_id' => $sessionId]);
                }
            }

            session()->put('cart_session_id', $cart->session_id);
            return $cart;

        } catch (Exception $e) {
            Log::error('Error creating/getting cart: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Helper method to calculate the total price of the cart.
     *
     * @param Cart $cart
     * @return float
     */
    protected function calculateCartTotal(Cart $cart): float
    {
        try {
            if (!$cart->relationLoaded('items')) {
                $cart->load('items');
            }

            return (float) $cart->items->sum('total');

        } catch (Exception $e) {
            Log::error('Error calculating cart total: ' . $e->getMessage());
            return 0.0;
        }
    }

    /**
     * Helper method to return success response.
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
     * Helper method to return error response.
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
