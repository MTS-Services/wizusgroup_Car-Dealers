<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\AddToCartRequest;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Services\Admin\ProductManagement\ProductService;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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
     * @return \Illuminate\Contracts\View\View
     */
    public function cart(): View
    {
        return view('frontend.pages.cart');
    }

    /**
     * Fetches all cart items for initial sidebar rendering.
     * This method is used for the initial load, not for subsequent updates.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchCartItems(): JsonResponse
    {
        $cart = $this->getOrUpdateCart();
        if (!$cart) {
            return response()->json([
                'status' => 'error',
                'message' => 'Cart not found',
            ]);
        }
        $cartItems = $cart ? $cart->items()->with('product.primaryImage', 'product.brand', 'product.model')->get() : [];
        $cartTotal = $this->calculateCartTotal($cart);

        return response()->json([
            'status' => 'success',
            'cart_items' => $cartItems,
            'cart_total' => $cartTotal,
        ]);
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
        $product = Product::findOrFail($request->product_id);
        $cart = $this->getOrCreateCart();
        $cart->load('items');
        $cartItem = $cart->items->where('product_id', $product->id)->first();
        $message = 'Something went wrong. Please try again.';
        $status = 'error';
        if ($cartItem) {
            $message = 'This product is already in your cart.';
            $status = 'info';
        } else {
            $cartItem = CartItem::create([
                'product_id' => $product->id,
                'quantity' => 1,
                'price' => $product->price,
                'cart_id' => $cart->id
            ]);
            $status = 'success';
            $cartItem->load('product.primaryImage', 'product.brand', 'product.model');
            $message = 'Product added to cart successfully.';
        }
        return response()->json([
            'status' => $status,
            'message' => $message,
            'cart_item' => $cartItem,
            'cart_total' => $this->calculateCartTotal($cart),
        ]);
    }

    /**
     * Update cart item quantity.
     * This method only returns the updated item's subtotal and the new cart total.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateCartQuantity(Request $request): JsonResponse
    {
        $itemId = $request->input('item_id');
        $newQuantity = (int) $request->input('new_quantity');


        $cartItem = CartItem::with('cart')->where('id', $itemId)->first();

        if (!$cartItem) {
            return response()->json([
                'status' => 'error',
                'message' => 'Cart item not found.'
            ], 404);
        }

        if ($newQuantity > $cartItem->product->quantity) {
            $newQuantity = $cartItem->product->quantity;
            return response()->json([
                'status' => 'info',
                'message' => 'Quantity limit reached.',
                'item_id' => $itemId,
                'new_quantity' => $newQuantity,
                'item_subtotal' => $cartItem->total,
                'cart_total' => $this->calculateCartTotal($cartItem->cart),
            ]);
        }

        // CHANGED: If new quantity is less than 1, set it to 1 and return an info message
        if ($newQuantity < 1) {
            $newQuantity = 1; // Force minimum quantity to 1
            $cartItem->quantity = $newQuantity;
            $cartItem->save(); // Save the item with quantity 1
            $cartTotal = $this->calculateCartTotal($cartItem->cart);
            $updatedItemSubtotal = $cartItem->total; // Recalculate total after change

            return response()->json([
                'status' => 'info', // Changed status to 'info' as it's not an error, but an adjustment
                'message' => 'Minimum quantity for this item is 1.', // Specific message
                'item_id' => $itemId, // Return the item ID
                'new_quantity' => $newQuantity, // Return the adjusted quantity
                'item_subtotal' => $updatedItemSubtotal, // Return the updated subtotal
                'cart_total' => $cartTotal,
            ]);
        }

        $cartItem->quantity = $newQuantity;
        $cartItem->save(); // This will trigger the updating event to recalculate $item->total

        $updatedItemSubtotal = $cartItem->total; // Use the already calculated total from the model
        $cartTotal = $this->calculateCartTotal($cartItem->cart);

        return response()->json([
            'status' => 'success',
            'message' => 'Cart item quantity updated.',
            'item_id' => $itemId,
            'new_quantity' => $cartItem->quantity,
            'item_subtotal' => $updatedItemSubtotal,
            'cart_total' => $cartTotal,
        ]);
    }

    /**
     * Remove item from cart.
     * This method only returns the ID of the removed item and the new cart total.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeCart(Request $request): JsonResponse
    {
        $itemId = $request->input('item_id');
        $cartItem = CartItem::with('cart')->where('id', $itemId)->first();

        if (!$cartItem) {
            return response()->json([
                'status' => 'error',
                'message' => 'Cart item not found.'
            ], 404);
        }

        $cartItem->forceDelete();
        $cartTotal = $this->calculateCartTotal($cartItem->cart);

        return response()->json([
            'status' => 'success',
            'message' => 'Item removed from cart.',
            'removed_item_id' => $itemId,
            'cart_total' => $cartTotal,
        ]);
    }

    /**
     * Helper method to get or create the appropriate cart.
     *
     * @return \App\Models\Cart
     */
    protected function getOrUpdateCart()
    {
        $cart = null;

        $sessionId = Session::getId();
        if (Auth::guard('web')->check()) {
            $userId = user()->id;
            $cart = Cart::where('user_id', $userId)->first();

            if ($cart) {
                $cart = Cart::update(['session_id' => $sessionId]);
            }
        } else {
            if (session()->has('cart_session_id')) {
                $cart = Cart::where('session_id', session()->get('cart_session_id'))->first();

                if ($cart) {
                    $cart->update([
                        'session_id' => $sessionId
                    ]);
                }
            }
        }
        if ($cart) {
            session()->put('cart_session_id', $cart->session_id);
        }
        return $cart;
    }

    protected function getOrCreateCart()
    {
        $cart = null;

        $sessionId = Session::getId();
        if (Auth::guard('web')->check()) {
            $userId = user()->id;
            $cart = Cart::updateOrCreate(['user_id' => $userId], ['session_id' => $sessionId]);
        } else {
            if (session()->has('cart_session_id')) {
                $cart = Cart::where('session_id', session()->get('cart_session_id'))->first();

                if ($cart) {
                    $cart->update([
                        'session_id' => $sessionId
                    ]);
                } else {
                    $cart = Cart::create(['session_id' => $sessionId]);
                }
            } else {
                $cart = Cart::create(['session_id' => $sessionId]);
            }
        }

        session()->put('cart_session_id', $cart->session_id);
        return $cart;
    }


    /**
     * Helper method to calculate the total price of the cart.
     *
     * @param \App\Models\Cart $cart
     * @return float
     */
    protected function calculateCartTotal(Cart $cart): float
    {
        $cart->load('items');
        $total = $cart->items->sum('total');
        return (float) $total;
    }
}
