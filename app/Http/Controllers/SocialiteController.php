<?php

namespace App\Http\Controllers;

use App\Models\Booking;
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
        try {
            $googleUser = Socialite::driver('google')->user();
    
            // Check email domain
            $emailDomain = substr(strrchr($googleUser->email, "@"), 1);
            if ($emailDomain !== 'mail.ugm.ac.id') {
                // Redirect to login page with an error message
                return redirect('/login')->with('error', 'Hanya email kampus @mail.ugm.ac.id yang dapat digunakan untuk login.');
            }
    
            $user = User::where('google_id', $googleUser->id)->first();
    
            if($user){
                Auth::login($user);
                if (empty($user->nama_lengkap)) {
                    return redirect()->route('pasien.profile',); 
                }

                return redirect()->route('home');
            } else {
                $userData = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                ]);
    
                if($userData){
                    Auth::login($userData);
                    return redirect()->route('pasien.profile')->with('success', "Silahkan isi data diri anda terelebih dahulu");
                }
            }
        } catch (\Exception $e) {
            // Handle any authentication errors
            return redirect('/login')->with('error', 'Gagal melakukan autentikasi. Silakan coba lagi.');
        }
    
        // Fallback redirect
        return redirect('/login')->with('error', 'Terjadi kesalahan dalam proses login.');
    }

    function logout() {
        Auth::logout(); 
        return redirect('/'); 
    }
}
