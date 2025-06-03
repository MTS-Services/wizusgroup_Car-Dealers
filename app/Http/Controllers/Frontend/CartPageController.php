<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\Admin\ProductManagement\ProductService;
use Illuminate\Http\Request;

class CartPageController extends Controller
{
    protected ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }
    public function cart()
    {
        $data['cart'] = session()->get('cart', []);
        // dd($data);
        return view('frontend.pages.cart', $data);
    }
    public function addCart(Request $request)
    {
        $product = $this->productService->getProduct(encrypt($request->product_id))->with('primaryImage')->first();
        $cart = session()->get('cart', []);
        $quantity = max(1, (int) $request->input('quantity', 1));

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $quantity;
        } else {
            $cart[$product->id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'model' => $product->model?->name,
                'quantity' => $quantity,
                'image' => $product->primaryImage->first()?->image ?? null,
            ];
        }

        session()->put('cart', $cart);
        return response()->json([
            'message' => 'Product added to cart',
            'cart_count' => count($cart),
            'data' => $cart
        ]);
    }
}
