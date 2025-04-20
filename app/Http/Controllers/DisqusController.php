<?php

use Laravel\Socialite\Facades\Socialite;

class DisqusController extends Controller
{
    public function redirectToProvider()
    {
        return Socialite::driver('disqus')->redirect();
    }

    public function handleProviderCallback()
    {
        $user = Socialite::driver('disqus')->user();
        // Simpan atau perbarui informasi pengguna di Laravel (misalnya: ID pengguna Disqus)
        Auth::login($user);

        return redirect()->route('home');
    }
}
