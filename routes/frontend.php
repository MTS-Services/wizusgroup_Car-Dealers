<?php


use App\Http\Controllers\Frontend\HomePageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\FrontendController;


Route::group(['as' => 'frontend.'], function () {
  //Dashboard
  Route::get('/dashboard', [FrontendController::class, 'dashboard'])->name('dashboard');
  // Home Page
  Route::get('/', [HomePageController::class, 'home'])->name('home');
  // Product Page
  Route::get('/product', [FrontendController::class, 'product'])->name('product');
  // Contact Page
  Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');
  // Contact Page
  Route::get('/auction', [FrontendController::class, 'auction'])->name('auction');
});
