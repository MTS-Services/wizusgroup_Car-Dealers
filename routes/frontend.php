<?php


use App\Http\Controllers\Frontend\HomePageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\FrontendController;


Route::group(['as' => 'frontend.'], function () {
  // Home Page
  Route::get('/', [HomePageController::class, 'home'])->name('home');
  // About Page
  Route::get('/about', [FrontendController::class, 'about'])->name('about');
  // Product Page
  Route::get('/product', [FrontendController::class, 'product'])->name('product');
  // Contact Page
  Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');
  // Contact Page
  Route::get('/auction', [FrontendController::class, 'auction'])->name('auction');
});
