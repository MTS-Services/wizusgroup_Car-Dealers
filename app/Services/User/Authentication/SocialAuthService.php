<?php

namespace App\Services\User\Authentication;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SocialAuthService
{
    public function redirectToProvider(string $provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback(string $provider)
    {
        $socialUser = Socialite::driver($provider)->stateless()->user();


        // Debug info, remove after testing
        // dd($socialUser);

        $user = User::updateOrCreate(
            ['email' => $socialUser->getEmail()],
            [
                'provider' => $provider,
                'provider_id' => $socialUser->getId(),
                'first_name' => $socialUser->getName() ?? $socialUser->getNickname(),
                'last_name' => $socialUser->getName() ?? $socialUser->getNickname(),
                'email_verified_at' => now(),
                'image' => $socialUser->getAvatar(),
                'password' => Str::random(16),
            ]
        );
    
        Auth::guard('web')->login($user, true);
        return $user;
    }
}
