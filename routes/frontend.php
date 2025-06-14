<?php

use App\Http\Controllers\Frontend\AuctionPageController;
use App\Http\Controllers\Frontend\AuctionDetailsPageController;
use App\Http\Controllers\Frontend\CartPageController;
use App\Http\Controllers\Frontend\CheckoutPageController;
use App\Http\Controllers\Frontend\ContactPageController;
use App\Http\Controllers\Frontend\HomePageController;
use App\Http\Controllers\Frontend\ProductPageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Frontend\GroupShippingPageController;
use App\Http\Controllers\Frontend\PartsAccessoriesPageController;
use App\Http\Controllers\Frontend\RegionPageController;

Route::group(['as' => 'frontend.'], function () {
    // Home Page
    Route::get('/', [HomePageController::class, 'home'])->name('home');
    // About Page
    Route::get('/about', [FrontendController::class, 'about'])->name('about');
    Route::get('/orders', [FrontendController::class, 'testContainerPage'])->name('orders');
    Route::get('/terms-and-conditions', [FrontendController::class, 'terms'])->name('terms');

    Route::controller(FrontendController::class)->group(function () {
        Route::get('order/group-shipping', 'group_shipping')->name('order.group_shipping');
        Route::get('order/join-group-shipping/{container_slug}/{product_slug?}', 'joinGroupShipping')->name('order.join-group-shipping');
        Route::post('order/group-shipping/join-request/{container_slug}', 'joinRequest')->name('group-shipping.join-request')->middleware('auth:web');
    });
    // Product Page
    Route::controller(ProductPageController::class)->group(function () {
        Route::get('/products/{category_slug?}', 'products')->name('products');
        Route::post('/products-filter/{category_slug?}', 'productFilter')->name('products.filter');
        Route::get('/product-details/{slug}', 'productDetails')->name('product.details');
    });
    // Contact Page
    Route::controller(ContactPageController::class)->prefix('contact')->group(function () {
        Route::get('/', 'contact')->name('contact');
        Route::post('/store', 'store')->name('contact-store');
    });

    // Auction Page
    Route::controller(AuctionPageController::class)->group(function () {
        Route::get('/auctions', 'auction')->name('auctions');
        Route::post('/auctions-filter', 'auctionFilter')->name('auctions.filter');
        Route::get('/auction/{slug}', 'auctionDetails')->name('auction-details');
    });

    // Parts & Accessories Page
    Route::controller(PartsAccessoriesPageController::class)->group(function () {
        Route::get('/parts-accessories', 'parts')->name('parts-accessories');
        Route::post('/parts-accessories-filter', 'productFilter')->name('parts-accessories.filter');
        Route::get('/parts-accessories/{slug}', 'partsDetails')->name('parts-accessories.details');
    });


    // group Shipping page
    Route::controller(GroupShippingPageController::class)->group(function () {
        Route::get('/group-shipping', 'group_shipping')->name('group_shipping');
        Route::get('/join-group-shipping/{container_slug}/{product_slug?}', 'joinGroupShipping')->name('join-group-shipping');
        Route::post('/group-shipping/join-request/{container_slug}', 'joinRequest')->name('group-shipping.join-request')->middleware('auth:web');
    });

    // droopshipping
    Route::get('/drop-shipping', [FrontendController::class, 'dropshipping'])->name('dropshipping');

    //   Region Page
    Route::get('/region', [RegionPageController::class, 'region'])->name('regions');

    // Cart Page
    Route::controller(CartPageController::class)->group(function () {
        Route::get('/cart', 'cart')->name('cart');
        Route::post('/cart/add', 'addCart')->name('cart.add');
        Route::post('/cart/items', 'fetchCartItems')->name('cart.items'); // For initial fetch
        Route::post('/cart/update-quantity', 'updateCartQuantity')->name('cart.update-quantity'); // New route for quantity update
        Route::post('/cart/remove', 'removeCart')->name('cart.remove'); // To remove an item
    });

    // Checkout Page
    Route::controller(CheckoutPageController::class)->group(function () {
        Route::post('/checkout/submit', 'checkoutSubmit')->name('checkout.submit');
        Route::get('/checkout/single/{slug}', 'singleOrder')->name('checkout.single');
        Route::get('/checkout/{orderNumber}', 'checkout')->name('checkout');

        Route::post('/checkout/quantity-update', 'quantityUpdate')->name('checkout.quantity-update');
        Route::post('/checkout/remove-item', 'removeItem')->name('checkout.remove-item');
        Route::post('/checkout/order-items', 'fetchOrderItems')->name('checkout.items');


        Route::post('/checkout-order/submit/{orderNumber}', 'orderSubmit')->name('checkout-order.submit');
        Route::get('container-order/{orderNumber}', 'containerOrder')->name('container-order')->middleware('auth:web');
        Route::get('order/join-container/{orderNumber}/{containerSlug}', 'joinContainer')->name('order.join-container')->middleware('auth:web');
        Route::get('order/container-request/{orderNumber}', 'containerRequest')->name('order.request-container')->middleware('auth:web');


    });


});
