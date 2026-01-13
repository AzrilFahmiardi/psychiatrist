<?php

use App\Http\Controllers\AdminBookingController;
use App\Http\Controllers\AdminJadwalController;
use App\Http\Controllers\AdminPsikologController;
use App\Http\Controllers\AgendaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\SocialiteController;
use App\Http\Controllers\AdminUserController;

/**
 * Public Routes
 * Accessible to everyone, but authenticated admin/psikolog will be redirected to their dashboards
 */
Route::middleware(['redirect.by.role'])->group(function () {
    Route::get('/', [JadwalController::class, 'index'])->name('home');
    Route::get('/jadwal', [JadwalController::class, 'filterJadwal'])->name('jadwal.filter');
});

Route::get('/privacy-policy', function () {
    return view('components.privacyPolicy');
});
Route::get('/term-of-service', function () {
    return view('components.termOfService');
});

/**
 * Guest Only Routes
 * Accessible only when not authenticated
 * Redirects to appropriate dashboard if user is already logged in
 */
Route::middleware(['guest'])->group(function () {
    Route::get('/login', function () {
        return view('login');
    })->name('login');
    
    Route::get('/register', function () {
        return view('register');
    });
    
    Route::get('/login-psikolog', [SocialiteController::class, 'nonPasienLoginPage'])->name('nonPasien.loginpage');
    Route::get('/login-admin', [SocialiteController::class, 'nonPasienLoginPage']);
    
    Route::get('/auth/google', [SocialiteController::class, 'googleLogin'])->name('auth.google');
});

/**
 * Authentication Callbacks
 * Must be accessible during the authentication process
 */
Route::get('/auth/google-callback', [SocialiteController::class, 'googleAuthentication'])->name('auth.google-callback');
Route::post('/login-psikolog', [SocialiteController::class, 'nonPasienLogin'])->name('auth.nonPasien');
Route::post('/login-admin', [SocialiteController::class, 'nonPasienLogin']);

/**
 * Logout Routes
 * Requires authentication - any authenticated user can logout
 */
Route::middleware(['auth'])->group(function () {
    Route::get('/logout', [SocialiteController::class, 'logout'])->name('google.logout');
    Route::get('/logout2', [SocialiteController::class, 'nonPasienLogout'])->name('nonPasien.logout');
});

/**
 * Pasien Only Routes
 * Requires authentication with 'user' or 'pasien' role
 * Admin and Psikolog will be redirected to their respective dashboards
 */
Route::middleware(['pasien'])->group(function () {
    Route::get('/profile', [PasienController::class, 'getData'])->name('pasien.profile');
    Route::post('/profile/update', [PasienController::class, 'updateDataPasien'])->name('pasien.update');
    
    Route::get('/riwayat', [RiwayatController::class, 'getBooking'])->name('riwayat.booking');
    
    Route::get('/my-calendar', [CalendarController::class, 'show'])->name('calendar.show');
    
    /**
     * Booking Forms - Requires completed profile
     */
    Route::middleware(['profile.complete'])->group(function () {
        Route::get('/form/persetujuan', [FormController::class, 'persetujuan'])->name('form.persetujuan');
        Route::get('/form/data-diri', [FormController::class, 'data_diri'])->name('form.data_diri');
        Route::get('/form/pilih-jadwal', [FormController::class, 'pilih_jadwal'])->name('form.pilih_jadwal');
        Route::get('/form/pilih-jadwal/update', [FormController::class, 'filterJadwal'])->name('form.pilih_jadwal.update');
        Route::get('/form/ketentuan-submit', [FormController::class, 'ketentuan_submit'])->name('form.ketentuan_submit');
        Route::get('/form/pembayaran', [FormController::class, 'pembayaran'])->name('form.pembayaran');
        Route::post('/submit-booking', [FormController::class, 'simpan_booking'])->name('submit.booking');
        Route::post('/booking/{booking}/cancel', [FormController::class, 'cancel_booking'])->name('booking.cancel');
    });
});

/**
 * Psikolog Only Routes
 * Requires authentication with 'psikolog' role
 * Pasien and Admin will be blocked or redirected
 */
Route::middleware(['psikolog'])->group(function () {
    Route::get('/home-psikolog', [AgendaController::class, 'homePsikolog'])->name('home.psikolog');
    Route::get('/agenda-psikolog', [AgendaController::class, 'agendaPsikolog'])->name('agenda.psikolog');
    Route::get('/agenda-psikolog/filter', [AgendaController::class, 'agendaPsikologFilterJadwal'])->name('agenda.psikolog.filter');
    Route::post('/add-konsultasi', [AgendaController::class, 'addKonsultasi'])->name('add.konsultasi');
    Route::post('/update-konsultasi', [AgendaController::class, 'updateKonsultasi'])->name('update.konsultasi');
});

/**
 * Admin Only Routes
 * Requires authentication with 'admin' role
 * Pasien and Psikolog will be blocked
 */
Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('psikologs', AdminPsikologController::class);
    Route::resource('jadwals', AdminJadwalController::class)->only(['index', 'create', 'store', 'destroy']);
    Route::resource('bookings', AdminBookingController::class)->only(['index', 'edit', 'update']);
    Route::resource('users', AdminUserController::class);
});
