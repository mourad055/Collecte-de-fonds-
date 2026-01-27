<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SocialAuthController extends Controller
{
    public function redirectGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogle()
    {
        $googleUser = Socialite::driver('google')->user();

        $user = User::updateOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name' => $googleUser->getName(),
                'google_id' => $googleUser->getId(),
                'password' => bcrypt(Str::random(16)),
            ]
        );

        Auth::login($user, true);

        return redirect()->route('dashboard');
    }

    public function redirectFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebook()
    {
        $fbUser = Socialite::driver('facebook')->user();

        $user = User::updateOrCreate(
            ['email' => $fbUser->getEmail()],
            [
                'name' => $fbUser->getName(),
                'facebook_id' => $fbUser->getId(),
                'password' => bcrypt(Str::random(16)),
            ]
        );

        Auth::login($user, true);

        return redirect()->route('dashboard');
    }
}
