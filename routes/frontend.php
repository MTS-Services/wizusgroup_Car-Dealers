<?php

use App\Http\Controllers\Frontend\AuctionPageController;
use App\Http\Controllers\Frontend\AuctionDetailsPageController;
use App\Http\Controllers\Frontend\ContactPageController;
use App\Http\Controllers\Frontend\HomePageController;
use App\Http\Controllers\Frontend\ProductPageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Frontend\GroupShippingPageController;
use App\Http\Controllers\Frontend\PartsAccessoriesPageController;

Route::group(['as' => 'frontend.'], function () {
    // Home Page
    Route::get('/', [HomePageController::class, 'home'])->name('home');
    // About Page
    Route::get('/about', [FrontendController::class, 'about'])->name('about');
    // Product Page
    Route::controller(ProductPageController::class)->group(function () {
        Route::get('/products/{category_slug}',  'products')->name('products');
        Route::post('/products-filter/{category_slug}' , 'productFilter')->name('products.filter');
        Route::get('/product-details/{slug}',  'productDetails')->name('product.details');
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
    });

  // droopshipping
  Route::get('/dropshipping', [FrontendController::class, 'dropshipping'])->name('dropshipping');
  // Regions
  Route::get('/regions', [FrontendController::class, 'regions'])->name('regions');

  // Parts & Accessories Page
});
