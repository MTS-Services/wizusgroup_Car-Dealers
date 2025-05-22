<?php

use App\Http\Controllers\Frontend\AuctionDetailsPageController;
use App\Http\Controllers\Frontend\ContactPageController;
use App\Http\Controllers\Frontend\HomePageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Frontend\GroupShippingPageController;

Route::group(['as' => 'frontend.'], function () {
    // Home Page
    Route::get('/', [HomePageController::class, 'home'])->name('home');
    // About Page
    Route::get('/about', [FrontendController::class, 'about'])->name('about');
    // Product Page
    Route::get('/product', [FrontendController::class, 'product'])->name('product');
    // Contact Page
    Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');
    // Auction Page
    Route::get('/auction', [FrontendController::class, 'auction'])->name('auction');
    // Auction Details Page
    Route::get('/auction-details', [AuctionDetailsPageController::class, 'auction_details'])->name('auction-details');
    // Parts & Accessories Page
    Route::get('/parts-accessories', [FrontendController::class, 'parts_accessories'])->name('parts-accessories');
    //  Product Details Page
    Route::get('/product-details', [FrontendController::class, 'product_details'])->name('product_details');
    // group Shipping page
    Route::get('/group-shipping', [GroupShippingPageController::class, 'group_shipping'])->name('group_shipping');
    // droopshipping
    Route::get('/dropshipping', [FrontendController::class, 'dropshipping'])->name('dropshipping');
    // Regions
    Route::get('/regions', [FrontendController::class, 'regions'])->name('regions');
    // Contact Us
    Route::post('/contact-store', [ContactPageController::class, 'store'])->name('contact-store');
});
