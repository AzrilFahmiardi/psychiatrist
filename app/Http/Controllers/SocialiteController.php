<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    function googleLogin(){
        return Socialite::driver('google')->redirect();
    }

    function googleAuthentication(){
        $googleUser = Socialite::driver('google')->user();

        // $emailDomain = substr(strrchr($googleUser->email, "@"), 1);
        // if ($emailDomain !== 'mail.ugm.ac.id') {
        //     return redirect('/')->withErrors(['email' => 'Hanya email kampus @mail.ugm.ac.id yang dapat digunakan untuk login.']);
        // }

        $user = User::where('google_id', $googleUser->id)->first();

        if($user){
            Auth::login($user);
            if (empty($user->nama_lengkap)) {
            return redirect()->route('pasien.profile'); 
        }

        return redirect()->route('home'); // Redirect ke halaman utama
        }else{
            $userData = User::create([
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'google_id' => $googleUser->id,
            ]);

            if($userData){
                Auth::login($userData);
                if (empty($user->nama_lengkap)) {
            return redirect()->route('pasien.profile'); 
        }

        return redirect()->route('home'); // Redirect ke halaman utama
            }
        }

        
    }

    function logout() {
        Auth::logout(); 
        return redirect('/'); 
    }
}
