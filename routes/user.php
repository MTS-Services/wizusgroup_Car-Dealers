<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\User\DashboardController as UserDashboardController;
use App\Http\Controllers\Frontend\AuthController;

Auth::routes([
  'verify' => true
]);

Route::middleware(['auth:web', 'verified'])->group(function () {
  Route::get('/profile', [UserDashboardController::class, 'profile'])->name('user.profile');
});