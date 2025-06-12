<?php

use App\Http\Controllers\Auth\SocialAuthController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\User\UserProfileController;
use App\Http\Controllers\Backend\User\AuctionManagement\AuctionBidPlaceController;
use App\Http\Controllers\Backend\User\ProductReserveInquiryController;

Auth::routes([
    'verify' => true
]);

Route::get('auth/redirect/{provider}', [SocialAuthController::class, 'redirect'])
    ->where('provider', 'google|facebook')
    ->name('auth.social.redirect');

Route::get('auth/callback/{provider}', [SocialAuthController::class, 'callback'])
    ->where('provider', 'google|facebook')
    ->name('auth.social.callback');

Route::middleware(['auth:web', 'verified'])->group(function () {
    Route::group(['as' => 'user.'], function () {
        // User Profile
        Route::controller(UserProfileController::class)->group(function () {
            Route::get('/profile', 'profile')->name('profile');
            Route::put('/profile/update', 'profileUpdate')->name('profile.update');
            Route::put('/address/update', 'addressUpdate')->name('address.update');
            Route::put('/password/update', 'passwordUpdate')->name('password.update');

            Route::get('auction/details/{auction_slug}', 'auctionDetails')->name('auction.details');
            Route::get('container/details/{container_slug}', 'containerDetails')->name('container.details');
            Route::get('order/details/{order_number}', 'orderDetails')->name('order.details');

        });

        // Auction Bid Place Route
        Route::controller(AuctionBidPlaceController::class)->prefix('bid-place')->name('auction.')->group(function () {
            Route::post('/place/{slug}', 'placeBid')->name('bid-place');
        });

        Route::controller(ProductReserveInquiryController::class)->name('p.')->group(function () {
            Route::post('/reserve/{slug}', 'reserveStore')->name('reserve-store');
            Route::post('/inquiry/{slug}', 'inquiryStore')->name('inquiry-store');
        });
    });
});
