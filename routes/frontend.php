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
// droopshipping
Route::get('/dropshipping', [FrontendController::class, 'dropshipping'])->name('dropshipping');
// Regions
Route::get('/regions', [FrontendController::class, 'regions'])->name('regions');
});
