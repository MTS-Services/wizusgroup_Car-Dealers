<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\User\DashboardController as UserDashboardController;
use App\Http\Controllers\Backend\User\UserProfileController;
use App\Http\Controllers\Frontend\AuthController;

Auth::routes([
  'verify' => true
]);

Route::middleware(['auth:web', 'verified'])->group(function () {
  Route::get('/profile', [UserDashboardController::class, 'profile'])->name('user.profile');
});

 // User Profile
    Route::controller(UserProfileController::class)->name('user.')->group(function () {
        Route::get('/profile', 'profile')->name('profile');
        Route::put('/profile/update', 'profileUpdate')->name('profile.update');
        Route::put('/address/update', 'addressUpdate')->name('address.update');
        Route::put('/password/update', 'passwordUpdate')->name('password.update');
    });