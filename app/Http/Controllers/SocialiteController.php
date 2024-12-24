<?php

namespace App\Http\Controllers;

use Log;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Jadwal;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    function googleLogin(){
        $params = [
            'access_type' => 'offline',
            'prompt' => 'consent select_account'
        ];
        
        return Socialite::driver('google')
            ->setScopes([
                'openid', 
                'email', 
                'profile',
                'https://www.googleapis.com/auth/calendar',
                'https://www.googleapis.com/auth/calendar.events'
            ])
            ->with($params)
            ->redirect();
    }

    function googleAuthentication(){
        try {
            $googleUser = Socialite::driver('google')->user();
    
            // Check email domain
            $emailDomain = substr(strrchr($googleUser->email, "@"), 1);
            if ($emailDomain !== 'mail.ugm.ac.id') {
                return redirect('/login')->with('error', 'Hanya email kampus @mail.ugm.ac.id yang dapat digunakan untuk login.');
            }
    
            // Format token dengan benar
            $token = [
                'access_token' => $googleUser->token,
                'refresh_token' => $googleUser->refreshToken,
                'expires_in' => $googleUser->expiresIn,
                'scope' => implode(' ', [
                    'https://www.googleapis.com/auth/calendar',
                    'https://www.googleapis.com/auth/calendar.events',
                    'openid',
                    'email',
                    'profile'
                ]),
                'token_type' => 'Bearer',
                'created' => time()
            ];
    
            // Debug: Log token sebelum disimpan
            Log::info('Token to be saved:', [
                'token' => $token
            ]);
    
            $user = User::where('google_id', $googleUser->id)->first();
    
            if($user){
                $user->google_token = json_encode($token);
                $user->save();
                
                Auth::login($user);
                if (empty($user->nama_lengkap)) {
                    return redirect()->route('pasien.profile'); 
                }
                return redirect()->route('home');
            } else {
                $userData = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'google_token' => json_encode($token),
                ]);
    
                if($userData){
                    Auth::login($userData);
                    return redirect()->route('pasien.profile')
                        ->with('success', "Silahkan isi data diri anda terelebih dahulu");
                }
            }
        } catch (\Exception $e) {
            Log::error('Google Authentication Error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect('/login')->with('error', 'Gagal melakukan autentikasi. Silakan coba lagi.');
        }
    
        return redirect('/login')->with('error', 'Terjadi kesalahan dalam proses login.');
    }

    function logout() {
        Auth::logout(); 
        return redirect('/'); 
    }



    // LOGIN NON PASIEN
    function nonPasienLoginPage(){
        return view('login2');
    }
    function nonPasienLogin(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'Email tidak ditemukan.');
        }

        // Periksa password
        if (!Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Password salah.');
        }

        // Login user
        Auth::login($user);

        // Redirect berdasarkan role
        if ($user->role === 'psikolog') {
            return redirect()->route('home.psikolog');
        } elseif ($user->role === 'admin') {
            return redirect()->route('admin.psikologs.index');
        } else {
            return redirect()->route('user.dashboard');
        }
    }

    function nonPasienLogout(){
        Auth::logout(); 
        return redirect('/login2'); 
    }

}