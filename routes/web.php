<?php

use Carbon\Carbon;
use App\Models\User;
use App\Models\Jadwal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\SocialiteController;


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

Route::middleware(['auth'])->group(function () {
    Route::get('/my-calendar', [CalendarController::class, 'show'])->name('calendar.show');
});

// ADMIN ROUTES
// Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', function () {
        return view('admin.home');
    });

    // Route::get('/admin/jadwal', [JadwalController::class, 'index'])->name('admin.jadwal');
    // Route::get('/admin/jadwal/create', [JadwalController::class, 'create'])->name('admin.jadwal.create');
    // Route::post('/admin/jadwal/store', [JadwalController::class, 'store'])->name('admin.jadwal.store');
    // Route::get('/admin/jadwal/edit/{id}', [JadwalController::class, 'edit'])->name('admin.jadwal.edit');
    // Route::post('/admin/jadwal/update/{id}', [JadwalController::class, 'update'])->name('admin.jadwal.update');
    // Route::get('/admin/jadwal/delete/{id}', [JadwalController::class, 'destroy'])->name('admin.jadwal.delete');

    // Route::get('/admin/pasien', [PasienController::class, 'index'])->name('admin.pasien');
    // Route::get('/admin/pasien/create', [PasienController::class, 'create'])->name('admin.pasien.create');
    // Route::post('/admin/pasien/store', [PasienController::class, 'store'])->name('admin.pasien.store');
    // Route::get('/admin/pasien/edit/{id}', [PasienController::class, 'edit'])->name('admin.pasien.edit');
    // Route::post('/admin/pasien/update/{id}', [PasienController::class, 'update'])->name('admin.pasien.update');
    // Route::get('/admin/pasien/delete/{id}', [PasienController::class, 'destroy'])->name('admin.pasien.delete');

    // Route::get('/admin/riwayat', [RiwayatController::class, 'index'])->name('admin.riwayat');
    // Route::get('/admin/riwayat/create', [RiwayatController::class, 'create'])->name('admin.riwayat.create');
    // Route::post('/admin/riwayat/store', [RiwayatController::class, 'store'])->name('admin.riwayat.store');
    
    // Route::get('/admin/riwayat/edit/{id}', [RiwayatController::class, 'edit'])->name('admin.riwayat.edit');
    // Route::post('/admin/riwayat/update/{id}', [RiwayatController::class, 'update'])->name('admin.riwayat.update');
    // Route::get('/admin/riwayat/delete/{id}', [RiwayatController::class, 'destroy'])->name('admin.riwayat.delete');
// });

