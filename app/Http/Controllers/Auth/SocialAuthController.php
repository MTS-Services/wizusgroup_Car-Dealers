<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\User\Authentication\SocialAuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SocialAuthController extends Controller
{
    public function __construct(private SocialAuthService $socialAuthService) {}

    public function redirect(string $provider): RedirectResponse
    {
        return $this->socialAuthService->redirectToProvider($provider);
    }

    public function callback(string $provider): RedirectResponse
    {
        $this->socialAuthService->handleProviderCallback($provider);

        return redirect()->intended('/user/profile'); // Redirect after login
    }
}
