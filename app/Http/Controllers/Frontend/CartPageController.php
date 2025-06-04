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
        $cart = $this->getOrCreateCart();
        return view('frontend.pages.cart', ['cart' => $cart]);
    }

    /**
     * Fetches all cart items for initial sidebar rendering.
     * This method is used for the initial load, not for subsequent updates.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchCartItems(): JsonResponse
    {
        $cart = $this->getOrCreateCart();
        // Eager load product details including primaryImage, brand, and model
        $cartItems = $cart->items()->with('product.primaryImage', 'product.brand', 'product.model')->get();
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
        $productId = $request->input('product_id');
        $quantity = 1; // Default quantity as per your Axios call

        $product = Product::find($productId);

        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found.'
            ], 404);
        }

        $cart = $this->getOrCreateCart();
        $cartItem = $cart->items()->where('product_id', $productId)->first();

        if ($cartItem) {
            // Product already in cart, update quantity
            $cartTotal = $this->calculateCartTotal($cart);
            return response()->json([
                'status' => 'info',
                'message' => 'This product is already in your cart.',
                'cart_item' => $cartItem, // Return existing cart item details
                'cart_total' => $cartTotal,
            ]);
        } else {
            // Product not in cart, add new item
            $cartItem = new CartItem([
                'product_id' => $productId,
                'quantity' => $quantity,
                'price' => $product->price, // Store current price
            ]);
            $cart->items()->save($cartItem);

            // Load relationships for the newly created cart item to return full details

            $cartTotal = $this->calculateCartTotal($cart);

            return response()->json([
                'status' => 'success',
                'message' => 'Product added to cart successfully!',
                'cart_item' => $cartItem, // Return newly added cart item details
                'cart_total' => $cartTotal,
            ]);
        }
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

        $cart = $this->getOrCreateCart();
        $cartItem = $cart->items()->where('id', $itemId)->first();

        if (!$cartItem) {
            return response()->json([
                'status' => 'error',
                'message' => 'Cart item not found.'
            ], 404);
        }

        if ($newQuantity < 1) {
            // If new quantity is less than 1, remove the item
            $cartItem->delete();
            $cartTotal = $this->calculateCartTotal($cart);
            return response()->json([
                'status' => 'removed', // Custom status for item removal
                'message' => 'Item removed from cart.',
                'removed_item_id' => $itemId,
                'cart_total' => $cartTotal,
            ]);
        }

        $cartItem->quantity = $newQuantity;
        $cartItem->save();

        $updatedItemSubtotal = $cartItem->price * $cartItem->quantity;
        $cartTotal = $this->calculateCartTotal($cart);

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

        $cart = $this->getOrCreateCart();
        $cartItem = $cart->items()->where('id', $itemId)->first();

        if (!$cartItem) {
            return response()->json([
                'status' => 'error',
                'message' => 'Cart item not found.'
            ], 404);
        }

        $cartItem->delete();
        $cartTotal = $this->calculateCartTotal($cart);

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
    // protected function getOrCreateCart(): Cart
    // {
    //     $cart = null;

    //     if (Auth::guard('web')->check()) {
    //         $userId = Auth::guard('web')->id();
    //         $cart = Cart::where('user_id', $userId)->first();

    //         if (!$cart) {
    //             $cart = Cart::create([
    //                 'user_id' => $userId,
    //                 'session_id' => Session::getId(),
    //             ]);
    //         }
    //     } else {
    //         $sessionId = Session::getId();
    //         $cart = Cart::where('session_id', $sessionId)->first();

    //         if (!$cart) {
    //             $cart = Cart::create([
    //                 'session_id' => $sessionId,
    //                 'user_id' => null,
    //             ]);
    //         }
    //     }

    //     return $cart;
    // }

    protected function getOrCreateCart()
    {
        $cart = null;

        $sessionId = Session::getId();
        if (Auth::guard('web')->check()) {
            $userId = user()->id;
            $cart = Cart::updateOrCreate(
                ['user_id' => $userId],
                ['session_id' => $sessionId,]
            );
        } else {
            if (session()->has('cart_session_id')) {
                $cart = Cart::where('session_id', session()->get('cart_session_id'))->first();
                if ($cart) {
                    $cart->update([
                        'session_id' => $sessionId
                    ]);
                }

            } else {
                $cart = Cart::create([
                    'session_id' => $sessionId
                ]);
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
        // Recalculate total from fresh items to ensure accuracy
        $total = $cart->items()->sum(function ($item) {
            return $item->price * $item->quantity;
        });
        return (float) $total;
    }
}
