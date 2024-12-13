<?php

use App\Http\Controllers\FormController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\SocialiteController;
use Illuminate\Support\Facades\Route;

// PAGES
Route::get('/', function () {
    return  view('home');
})->name('home');

Route::get('/login', function () {
    return view('login');
});

Route::get('/register', function () {
    return view('register');
});

Route::get('/profile', function () {
    return view('components.profile');
});

// GOOGLE AUTHENTICATION
Route::get('/auth/google', [SocialiteController::class, 'googleLogin'])->name('auth.google');
Route::get('/auth/google-callback', [SocialiteController::class, 'googleAuthentication'])->name('auth.google-callback');
Route::get('/logout', [SocialiteController::class, 'logout'])->name('google.logout');

// FORM DATA PASIEN
Route::post('/profile/update',[PasienController::class, 'updateDataPasien'])->name('pasien.update');


// FORM BOOKING
Route::get('/form/persetujuan', [FormController::class, 'persetujuan'])->name('form.persetujuan');
Route::get('/form/data-diri', [FormController::class, 'data_diri'])->name('form.data_diri');
Route::get('/form/pilih-jadwal', [FormController::class, 'pilih_jadwal'])->name('form.pilih_jadwal');
Route::get('/form/ketentuan-submit', [FormController::class, 'ketentuan_submit'])->name('form.ketentuan_submit');
Route::get('/form/pembayaran', [FormController::class, 'pembayaran'])->name('form.pembayaran');

