<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Services\Admin\ProductManagement\ProductService;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $data['cart'] = session()->get('cart', []);
        // dd($data);
        return view('frontend.pages.cart', $data);
    }

    /**
     * Add a product to the cart (session or database).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    // public function addCart(Request $request): JsonResponse
    // {

    //     $request->validate([
    //         'product_id' => 'required', // Assuming it's encrypted, so no exists validation here directly
    //         'quantity' => 'nullable|integer|min:1',
    //     ]);

    //     try {
    //         $productId = decrypt($request->product_id);
    //         $product = $this->productService->getProduct($productId);
    //         $product->load('primaryImage');
    //         if (!$product) {
    //             return response()->json(['message' => 'Product not found.'], 404);
    //         }
    //         $quantity = max(1, (int) $request->input('quantity', 1));

    //         $cartItemData = [
    //             'id' => $product->id,
    //             'name' => $product->name,
    //             'price' => (string)$product->price,
    //             'model' => $product->model?->name ?? null,
    //             'quantity' => $quantity,
    //             'image' => $product->primaryImage->first()?->image ?? null,
    //         ];

    //         $currentCartItems = [];


    //         if (auth('web')->check()) {
    //             // User is logged in, use database cart
    //             $user = auth('web')->user();

    //             // Find or create the user's cart
    //             $userCart = Cart::firstOrCreate(['user_id' => $user->id]);
    //             // Find or create the cart item within the user's cart
    //             $cartItem = CartItem::where('cart_id', $userCart->id)
    //                 ->where('product_id', $product->id)
    //                 ->first();
    //             if ($cartItem) {
    //                 // Product already in cart, update quantity
    //                 $cartItem->quantity += $quantity;
    //                 $cartItem->save();
    //             } else {
    //                 // Product not in cart, add new item
    //                 CartItem::create([
    //                     'cart_id' => $userCart->id,
    //                     'product_id' => $product->id,
    //                     'quantity' => $quantity,
    //                     'price' => $product->price, // Store individual item price at time of adding
    //                 ]);
    //             }

    //             // After updating/adding, fetch all items for the user's cart to return to frontend
    //             $currentCartItems = $userCart->items->mapWithKeys(function ($item) {
    //                 return [
    //                     $item->product_id => [
    //                         'id' => $item->product_id,
    //                         'name' => $item->product->name, // Assuming a product relationship on CartItem
    //                         'price' => (string)$item->product->price, // Current product price
    //                         'model' => $item->product->model?->name ?? null,
    //                         'quantity' => $item->quantity,
    //                         'image' => $item->product->primaryImage->first()?->image ?? null,
    //                     ]
    //                 ];
    //             })->toArray();
    //         } else {
    //             // User is a guest, use session cart
    //             $cart = session()->get('cart', []);

    //             if (isset($cart[$product->id])) {
    //                 $cart[$product->id]['quantity'] += $quantity;
    //             } else {
    //                 $cart[$product->id] = $cartItemData;
    //             }

    //             session()->put('cart', $cart);
    //             $currentCartItems = $cart;
    //         }

    //         return response()->json([
    //             'message' => 'Product added to cart',
    //             'cart_count' => count($currentCartItems),
    //             'data' => $currentCartItems
    //         ]);
    //     } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
    //         return response()->json(['message' => 'Invalid product ID.'], 400);
    //     }

    //     // $cart = session()->get('cart', []);
    //     // $quantity = max(1, (int) $request->input('quantity', 1));
    //     // if (isset($cart[$product->id])) {
    //     //     $cart[$product->id]['quantity'] += $quantity;
    //     // } else {
    //     //     $cart[$product->id] = [
    //     //         'id' => $product->id,
    //     //         'name' => $product->name,
    //     //         'price' => $product->price,
    //     //         'model' => $product->model?->name,
    //     //         'quantity' => $request->quantity,
    //     //         'image' => $product->primaryImage->first()?->image ?? null,
    //     //     ];
    //     // }

    //     // session()->put('cart', $cart);

    //     // session()->put('cart', $cart);
    //     return response()->json([
    //         // 'message' => 'Product added to cart',
    //         // 'cart_count' => count($cart),
    //         'product' => $product,
    //         'id' => $product->id,
    //         'cart' => $cart
    //     ]);
    // }

    /**
     * Get all items currently in the cart session (for guests) or database (for logged-in users).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    // public function getCartItems(): JsonResponse
    // {
    //     $currentCartItems = [];

    //     if (auth('web')->check()) {
    //         $user = auth('web')->user();
    //         $userCart = Cart::with(['items.product.primaryImage', 'items.product.model'])->where('user_id', $user->id)->first();

    //         if ($userCart) {
    //             $currentCartItems = $userCart->items->mapWithKeys(function ($item) {
    //                 return [
    //                     $item->product_id => [
    //                         'id' => $item->product_id,
    //                         'name' => $item->product->name,
    //                         'price' => (string)$item->product->price,
    //                         'model' => $item->product->model?->name ?? null,
    //                         'quantity' => $item->quantity,
    //                         'image' => $item->product->primaryImage->first()?->image ?? null,
    //                     ]
    //                 ];
    //             })->toArray();
    //         }
    //     } else {
    //         $currentCartItems = session()->get('cart', []);
    //     }

    //     return response()->json([
    //         'message' => 'Cart items retrieved',
    //         'cart_count' => count($currentCartItems),
    //         'data' => $currentCartItems
    //     ]);
    // }

    /**
     * Update the quantity of a product in the cart (session or database).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    // public function updateCart(Request $request): JsonResponse
    // {
    //     $request->validate([
    //         'product_id' => 'required',
    //         'action' => 'required|in:increase,decrease',
    //     ]);

    //     try {
    //         $productId = decrypt($request->product_id);
    //     } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
    //         return response()->json(['message' => 'Invalid product ID.'], 400);
    //     }

    //     $currentCartItems = [];

    //     if (auth('web')->check()) {
    //         $user = auth('web')->user();
    //         $userCart = Cart::where('user_id', $user->id)->first();

    //         if ($userCart) {
    //             $cartItem = CartItem::where('cart_id', $userCart->id)
    //                 ->where('product_id', $productId)
    //                 ->first();

    //             if ($cartItem) {
    //                 if ($request->action === 'increase') {
    //                     $cartItem->quantity++;
    //                 } elseif ($request->action === 'decrease') {
    //                     $cartItem->quantity--;
    //                     if ($cartItem->quantity <= 0) {
    //                         $cartItem->delete(); // Remove item if quantity drops to 0 or less
    //                     }
    //                 }
    //                 if ($cartItem->exists) { // Only save if not deleted
    //                     $cartItem->save();
    //                 }
    //             }
    //         }
    //         // After updating, fetch all items for the user's cart to return to frontend
    //         $userCart->load(['items.product.primaryImage', 'items.product.model']); // Reload relationships
    //         if ($userCart) {
    //             $currentCartItems = $userCart->items->mapWithKeys(function ($item) {
    //                 return [
    //                     $item->product_id => [
    //                         'id' => $item->product_id,
    //                         'name' => $item->product->name,
    //                         'price' => (string)$item->product->price,
    //                         'model' => $item->product->model?->name ?? null,
    //                         'quantity' => $item->quantity,
    //                         'image' => $item->product->primaryImage->first()?->image ?? null,
    //                     ]
    //                 ];
    //             })->toArray();
    //         }
    //     } else {
    //         $cart = session()->get('cart', []);

    //         if (isset($cart[$productId])) {
    //             if ($request->action === 'increase') {
    //                 $cart[$productId]['quantity']++;
    //             } elseif ($request->action === 'decrease') {
    //                 $cart[$productId]['quantity']--;
    //                 if ($cart[$productId]['quantity'] <= 0) {
    //                     unset($cart[$productId]);
    //                 }
    //             }
    //             session()->put('cart', $cart);
    //         }
    //         $currentCartItems = $cart;
    //     }

    //     return response()->json([
    //         'message' => 'Cart updated',
    //         'cart_count' => count($currentCartItems),
    //         'data' => $currentCartItems
    //     ]);
    // }

    /**
     * Remove a product from the cart (session or database).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    // public function removeCart(Request $request)
    // {
    //     $request->validate([
    //         'product_id' => 'required',
    //     ]);

    //     try {
    //         $productId = decrypt($request->product_id);
    //     } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
    //         return response()->json(['message' => 'Invalid product ID.'], 400);
    //     }

    //     $currentCartItems = [];

    //     if (auth('web')->check()) {
    //         $user = auth('web')->user();
    //         $userCart = Cart::where('user_id', $user->id)->first();

    //         if ($userCart) {
    //             CartItem::where('cart_id', $userCart->id)
    //                 ->where('product_id', $productId)
    //                 ->delete();
    //         }
    //         // After removal, fetch all items for the user's cart to return to frontend
    //         $userCart->load(['items.product.primaryImage', 'items.product.model']); // Reload relationships
    //         if ($userCart) {
    //             $currentCartItems = $userCart->items->mapWithKeys(function ($item) {
    //                 return [
    //                     $item->product_id => [
    //                         'id' => $item->product_id,
    //                         'name' => $item->product->name,
    //                         'price' => (string)$item->product->price,
    //                         'model' => $item->product->model?->name ?? null,
    //                         'quantity' => $item->quantity,
    //                         'image' => $item->product->primaryImage->first()?->image ?? null,
    //                     ]
    //                 ];
    //             })->toArray();
    //         }
    //     } else {
    //         $cart = session()->get('cart', []);

    //         if (isset($cart[$productId])) {
    //             unset($cart[$productId]);
    //             session()->put('cart', $cart);
    //         }
    //         $currentCartItems = $cart;
    //     }

    //     return response()->json([
    //         'message' => 'Product removed from cart',
    //         'cart_count' => count($currentCartItems),
    //         'data' => $currentCartItems
    //     ]);
    // }


    /**
     * Helper function to get the current cart items.
     * Returns an Eloquent Collection for logged-in users, or a plain array for guests.
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection|array
     */
    protected function getCurrentCartItems()
    {
        if (auth('web')->check()) {
            $userCart = Cart::where('user_id', auth('web')->id())->first();
            // Eager load relationships for the response
            return $userCart ? $userCart->items()->with(['product.primaryImage', 'product.model'])->get() : collect();
        } else {
            // For guests, cart is stored directly in session as an associative array
            return session()->get('cart', []);
        }
    }

    /**
     * Helper function to format cart items for frontend response.
     * Can handle both Eloquent Collections (from DB) and plain arrays (from session).
     *
     * @param \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection|array $cartItems
     * @return array
     */
    protected function formatCartItemsForResponse($cartItems)
    {
        $formatted = [];
        foreach ($cartItems as $key => $item) {
            // If from database, $item is a CartItem model
            if ($item instanceof CartItem) {
                $product = $item->product;
                if (!$product) {
                    continue; // Skip if product is soft-deleted or missing
                }
                $formatted[$product->id] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => (string)$item->price, // Use cart_item's price
                    'model' => $product->model->name ?? null,
                    'quantity' => $item->quantity,
                    'image' => $product->primaryImage->first()?->image ?? null,
                ];
            } else {
                // If from session, $item is a plain array
                $formatted[$item['id']] = [
                    'id' => $item['id'],
                    'name' => $item['name'],
                    'price' => (string)$item['price'],
                    'model' => $item['model'] ?? null,
                    'quantity' => $item['quantity'],
                    'image' => $item['image'] ?? null,
                ];
            }
        }
        return $formatted;
    }

    /**
     * Add a product to the cart. Handles both guest (session) and logged-in (database) users.
     * Merges guest cart into user cart upon first logged-in cart action.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'quantity' => 'nullable|integer|min:1',
        ]);

        try {
            // Decrypt product ID. Assuming frontend sends encrypted ID.
            $productId = $request->product_id;
        } catch (DecryptException $e) { // Use specific DecryptException
            return response()->json(['message' => 'Invalid product ID.'], 400);
        }

        // Get product details using the decrypted ID
        $product = $this->productService->getProduct(encrypt($productId))->with('primaryImage', 'model')->first();

        if (!$product) {
            return response()->json(['message' => 'Product not found.'], 404);
        }

        $quantity = max(1, (int) $request->input('quantity', 1));

        // Define the structure for the item to be added/updated
        $newItemData = [
            'id' => $product->id,
            'name' => $product->name,
            'price' => (string)$product->price,
            'model' => $product->model?->name ?? null,
            'quantity' => $quantity,
            'image' => $product->primaryImage->first()?->image ?? null,
        ];

        DB::transaction(function () use ($request, $product, $quantity, $newItemData) {
            if (auth('web')->check()) {
                $user = auth('web')->user();
                $userId = $user->id;

                // 1. Find or create the user's database cart
                $userCart = Cart::firstOrCreate(
                    ['user_id' => $userId],
                    ['session_id' => null] // Ensure session_id is null for user carts
                );

                // 2. Check for an existing guest cart in the session
                $guestSessionCart = session()->get('cart', []);

                // 3. Merge guest session cart items into user's database cart if one exists
                if (!empty($guestSessionCart)) {
                    foreach ($guestSessionCart as $guestProductId => $guestItem) {
                        $existingUserCartItem = CartItem::where('cart_id', $userCart->id)
                            ->where('product_id', $guestProductId)
                            ->withTrashed() // Include soft-deleted for merging
                            ->first();

                        if ($existingUserCartItem) {
                            $existingUserCartItem->quantity += $guestItem['quantity'];
                            $existingUserCartItem->restore(); // Restore if soft-deleted
                            $existingUserCartItem->save();
                        } else {
                            CartItem::create([
                                'cart_id' => $userCart->id,
                                'product_id' => $guestProductId,
                                'quantity' => $guestItem['quantity'],
                                'price' => $guestItem['price'],
                                'total' => $guestItem['price'] * $guestItem['quantity'],
                            ]);
                        }
                    }
                    session()->forget('cart'); // Clear the session cart after merging
                }

                // 4. Add/Update the current product to the user's database cart
                $cartItem = CartItem::where('cart_id', $userCart->id)
                    ->where('product_id', $product->id)
                    ->withTrashed() // Include soft-deleted for update
                    ->first();

                if ($cartItem) {
                    $cartItem->quantity += $quantity;
                    $cartItem->restore(); // Restore if it was soft-deleted
                    $cartItem->save();
                } else {
                    CartItem::create([
                        'cart_id' => $userCart->id,
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                        'price' => $product->price,
                        'total' => $product->price * $quantity,
                    ]);
                }
            } else {
                // User is a guest, manage cart in session
                $cart = session()->get('cart', []);

                if (isset($cart[$product->id])) {
                    $cart[$product->id]['quantity'] += $quantity;
                } else {
                    $cart[$product->id] = $newItemData; // Use the prepared data
                }

                session()->put('cart', $cart);
            }
        }); // End DB::transaction

        // After transaction, retrieve the current cart items to return to frontend
        $currentCartItems = $this->getCurrentCartItems();
        $totalQuantity = 0;

        // Calculate total quantity based on the type of cartItems
        if ($currentCartItems instanceof \Illuminate\Database\Eloquent\Collection) {
            $totalQuantity = $currentCartItems->sum('quantity');
        } else { // It's a plain array from session
            foreach ($currentCartItems as $item) {
                $totalQuantity += $item['quantity'];
            }
        }


        return response()->json([
            'message' => 'Product added to cart',
            'cart_count' => $totalQuantity,
            'data' => $this->formatCartItemsForResponse($currentCartItems)
        ]);
    }

    /**
     * Get all items currently in the cart.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCartItems()
    {
        $currentCartItems = $this->getCurrentCartItems();
        $totalQuantity = 0;

        if ($currentCartItems instanceof \Illuminate\Database\Eloquent\Collection) {
            $totalQuantity = $currentCartItems->sum('quantity');
        } else {
            foreach ($currentCartItems as $item) {
                $totalQuantity += $item['quantity'];
            }
        }

        return response()->json([
            'message' => 'Cart items retrieved',
            'cart_count' => $totalQuantity,
            'data' => $this->formatCartItemsForResponse($currentCartItems)
        ]);
    }

    /**
     * Update the quantity of a product in the cart.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'action' => 'required|in:increase,decrease',
        ]);

        try {
            $productId = decrypt($request->product_id);
        } catch (DecryptException $e) {
            return response()->json(['message' => 'Invalid product ID.'], 400);
        }

        if (auth('web')->check()) {
            // Logged-in user: update database cart
            $userCart = Cart::where('user_id', auth('web')->id())->first();

            if (!$userCart) {
                return response()->json(['message' => 'Cart not found for user.'], 404);
            }

            $cartItem = $userCart->items()->where('product_id', $productId)->withTrashed()->first();

            if (!$cartItem) {
                return response()->json(['message' => 'Product not in cart.'], 404);
            }

            DB::transaction(function () use ($request, $cartItem) {
                if ($request->action === 'increase') {
                    $cartItem->quantity++;
                    $cartItem->restore();
                    $cartItem->save();
                } elseif ($request->action === 'decrease') {
                    $cartItem->quantity--;
                    if ($cartItem->quantity <= 0) {
                        $cartItem->delete(); // Soft delete
                    } else {
                        $cartItem->restore();
                        $cartItem->save();
                    }
                }
            });
        } else {
            // Guest user: update session cart
            $cart = session()->get('cart', []);

            if (!isset($cart[$productId])) {
                return response()->json(['message' => 'Product not in cart.'], 404);
            }

            if ($request->action === 'increase') {
                $cart[$productId]['quantity']++;
            } elseif ($request->action === 'decrease') {
                $cart[$productId]['quantity']--;
                if ($cart[$productId]['quantity'] <= 0) {
                    unset($cart[$productId]);
                }
            }
            session()->put('cart', $cart);
        }

        $currentCartItems = $this->getCurrentCartItems();
        $totalQuantity = 0;
        if ($currentCartItems instanceof \Illuminate\Database\Eloquent\Collection) {
            $totalQuantity = $currentCartItems->sum('quantity');
        } else {
            foreach ($currentCartItems as $item) {
                $totalQuantity += $item['quantity'];
            }
        }

        return response()->json([
            'message' => 'Cart updated',
            'cart_count' => $totalQuantity,
            'data' => $this->formatCartItemsForResponse($currentCartItems)
        ]);
    }

    /**
     * Remove a product from the cart.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
        ]);

        try {
            $productId = decrypt($request->product_id);
        } catch (DecryptException $e) {
            return response()->json(['message' => 'Invalid product ID.'], 400);
        }

        if (auth('web')->check()) {
            // Logged-in user: remove from database cart
            $userCart = Cart::where('user_id', auth('web')->id())->first();

            if (!$userCart) {
                return response()->json(['message' => 'Cart not found for user.'], 404);
            }

            $cartItem = $userCart->items()->where('product_id', $productId)->first();

            if (!$cartItem) {
                return response()->json(['message' => 'Product not in cart.'], 404);
            }

            DB::transaction(function () use ($cartItem) {
                $cartItem->delete(); // Soft delete
            });
        } else {
            // Guest user: remove from session cart
            $cart = session()->get('cart', []);

            if (!isset($cart[$productId])) {
                return response()->json(['message' => 'Product not in cart.'], 404);
            }

            unset($cart[$productId]);
            session()->put('cart', $cart);
        }

        $currentCartItems = $this->getCurrentCartItems();
        $totalQuantity = 0;
        if ($currentCartItems instanceof \Illuminate\Database\Eloquent\Collection) {
            $totalQuantity = $currentCartItems->sum('quantity');
        } else {
            foreach ($currentCartItems as $item) {
                $totalQuantity += $item['quantity'];
            }
        }

        return response()->json([
            'message' => 'Product removed from cart',
            'cart_count' => $totalQuantity,
            'data' => $this->formatCartItemsForResponse($currentCartItems)
        ]);
    }
}
