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
        // dd($data);
        return view('frontend.pages.cart', $cart);
    }

    public function addCart(AddToCartRequest $request) // Keeping your method name 'addCart'
    {
        $productId = $request->input('product_id');
        $quantity = 1; // Default quantity to 1 as per your Axios call

        $product = Product::find($productId);

        // 1. Find or Create the Cart for the User/Session
        $cart = $this->getOrCreateCart();

        // 2. Check if item already exists in cart, and DO NOT update quantity
        $cartItem = $cart->items()->where('product_id', $productId)->first();

        if ($cartItem) {
            return response()->json([
                'status' => 'info', // Using 'info' or 'warning' for 'already added'
                'message' => 'This product is already in your cart.'
            ]);
        } else {
            // Product not in cart, add new item
            $cartItem = new CartItem([
                'product_id' => $productId,
                'quantity' => $quantity,
                'price' => $product->price, // Store current price
            ]);
            $cart->items()->save($cartItem);

            // Optional: return updated cart count or item details
            $cartCount = $cart->items()->count();

            return response()->json([
                'status' => 'success',
                'message' => 'Product added to cart successfully!',
                'cart_item' => [
                    'product_name' => $product->name,
                    'quantity' => $quantity,
                    'price' => $product->price,
                    // You might want to return the actual CartItem ID or other relevant data
                ],
                'cart_count' => $cartCount
            ]);
        }
    }

    /**
     * Helper method to get or create the appropriate cart.
     * (Keep this method as it was in the previous example)
     *
     * @return \App\Models\Cart
     */
    protected function getOrCreateCart()
    {
        $cart = null;

        if (Auth::guard('web')->check()) {
            $userId = user()->id;
            $cart = Cart::where('user_id', $userId)->first();

            if (!$cart) {
                $cart = Cart::create([
                    'user_id' => $userId,
                    'session_id' => Session::getId(),
                ]);
            }
        } else {
            $sessionId = Session::getId();
            $cart = Cart::where('session_id', $sessionId)->first();

            if (!$cart) {
                $cart = Cart::create([
                    'session_id' => $sessionId,
                    'user_id' => null,
                ]);
            }
        }

        return $cart;
    }
}
