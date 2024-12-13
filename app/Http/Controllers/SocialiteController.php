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

        $user = User::where('google_id', $googleUser->id)->first();

        if($user){
            Auth::login($user);
            return view('home');
        }else{
            $userData = User::create([
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'google_id' => $googleUser->id,
            ]);

            if($userData){
                Auth::login($userData);
                return view('home');
            }
        }

        
    }

    function logout() {
        Auth::logout(); 
        return redirect('/'); 
    }
}
