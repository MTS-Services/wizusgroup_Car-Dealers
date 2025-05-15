<?php


use App\Http\Controllers\Frontend\HomePageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\FrontendController;


Route::group(['as' => 'frontend.'], function () {
  // Home Page
  Route::get('/', [HomePageController::class, 'home'])->name('home');

  // Product Page
  Route::get('/product', [FrontendController::class, 'product'])->name('product');
  // Contact Page
  Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');
  // Contact Page
  Route::get('/auction', [FrontendController::class, 'auction'])->name('auction');
//  Product Details Page
  Route::get('/product_details', [FrontendController::class, 'product_details'])->name('product_details');
// group Shipping page
Route::get('/group_shipping', [FrontendController::class, 'group_shipping'])->name('group_shipping');
});
