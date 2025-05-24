<?php

use App\Http\Controllers\Frontend\AuctionPageController;
use App\Http\Controllers\Frontend\AuctionDetailsPageController;
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
  Route::get('/products/{category_slug}', [ProductPageController::class, 'products'])->name('products');
  Route::post('/products-filter/{category_slug}', [ProductPageController::class, 'productFilter'])->name('products.filter');
  Route::get('/product-details/{slug}', [ProductPageController::class, 'productDetails'])->name('product.details');
  // Contact Page
  Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');
  // Auction Page
  Route::get('/auctions', [AuctionPageController::class, 'auction'])->name('auctions');
  Route::post('/auctions-filter', [AuctionPageController::class, 'auctionFilter'])->name('auctions.filter');
  // Auction Details Page
  Route::get('/auction/{slug}', [AuctionPageController::class, 'auctionDetails'])->name('auction-details');
  // Parts & Accessories Page
  Route::get('/parts-accessories', [PartsAccessoriesPageController::class, 'parts'])->name('parts-accessories');
  //  Product Details Page

  // group Shipping page
  Route::get('/group-shipping', [GroupShippingPageController::class, 'group_shipping'])->name('group_shipping');
  // droopshipping
  Route::get('/dropshipping', [FrontendController::class, 'dropshipping'])->name('dropshipping');
  // Regions
  Route::get('/regions', [FrontendController::class, 'regions'])->name('regions');

  // Parts & Accessories Page
});
