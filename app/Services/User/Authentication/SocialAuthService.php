<?php

namespace App\Services\User\Authentication;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class SocialAuthService
{
     public function redirectToProvider(string $provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback(string $provider)
    {
        $socialUser = Socialite::driver($provider)->stateless()->user();

        dd($socialUser);

        $user = User::updateOrCreate(
            [
                'email' => $socialUser->getEmail(),
            ],
            [
                'provider' => $provider,
                'provider_id' => $socialUser->getId(),
                'name' => $socialUser->getName() ?? $socialUser->getNickname(),
                'email_verified_at' => now(),
                'image' => $socialUser->getAvatar(),
            ]
        );

        Auth::guard('web')->login($user, true);

        return $user;
    }
}
