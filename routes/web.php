<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\SocialiteController;
use App\Models\Jadwal;
use Carbon\Carbon;


// PAGES
Route::get('/', [JadwalController::class, 'index'])->name('home');
Route::get('/jadwal', [JadwalController::class, 'filterJadwal'])->name('jadwal.filter');

Route::get('/login', function () {
    return view('login');
});

Route::get('/register', function () {
    return view('register');
});

// RIWAYAT
Route::get('/riwayat', [RiwayatController::class, 'getBooking'])->name('riwayat.booking');



// GOOGLE AUTHENTICATION
Route::get('/auth/google', [SocialiteController::class, 'googleLogin'])->name('auth.google');
Route::get('/auth/google-callback', [SocialiteController::class, 'googleAuthentication'])->name('auth.google-callback');
Route::get('/logout', [SocialiteController::class, 'logout'])->name('google.logout');

// FORM DATA PASIEN
Route::get('/profile',[PasienController::class, 'getData'])->name('pasien.profile');
Route::post('/profile/update',[PasienController::class, 'updateDataPasien'])->name('pasien.update');


// FORM BOOKING
Route::get('/form/persetujuan', [FormController::class, 'persetujuan'])->name('form.persetujuan');
Route::get('/form/data-diri', [FormController::class, 'data_diri'])->name('form.data_diri');
Route::get('/form/pilih-jadwal', [FormController::class, 'pilih_jadwal'])->name('form.pilih_jadwal');
Route::get('/form/pilih-jadwal/update', [FormController::class, 'filterJadwal'])->name('form.pilih_jadwal.update');
Route::get('/form/ketentuan-submit', [FormController::class, 'ketentuan_submit'])->name('form.ketentuan_submit');
Route::get('/form/pembayaran', [FormController::class, 'pembayaran'])->name('form.pembayaran');
Route::post('/submit-booking', [FormController::class, 'simpan_booking'])->name('submit.booking');


