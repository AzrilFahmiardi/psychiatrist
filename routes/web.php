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
use App\Http\Middleware\AdminMiddleware;

// PAGES
Route::get('/', [JadwalController::class, 'index'])->name('home');
Route::get('/jadwal', [JadwalController::class, 'filterJadwal'])->name('jadwal.filter');

Route::get('/login', function () {
    return view('login');
})->name('login');

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
Route::get('/profile', [PasienController::class, 'getData'])->name('pasien.profile');
Route::post('/profile/update', [PasienController::class, 'updateDataPasien'])->name('pasien.update');


// FORM BOOKING
Route::get('/form/persetujuan', [FormController::class, 'persetujuan'])->name('form.persetujuan');
Route::get('/form/data-diri', [FormController::class, 'data_diri'])->name('form.data_diri');
Route::get('/form/pilih-jadwal', [FormController::class, 'pilih_jadwal'])->name('form.pilih_jadwal');
Route::get('/form/pilih-jadwal/update', [FormController::class, 'filterJadwal'])->name('form.pilih_jadwal.update');
Route::get('/form/ketentuan-submit', [FormController::class, 'ketentuan_submit'])->name('form.ketentuan_submit');
Route::get('/form/pembayaran', [FormController::class, 'pembayaran'])->name('form.pembayaran');
Route::post('/submit-booking', [FormController::class, 'simpan_booking'])->name('submit.booking');
Route::post('/booking/{booking}/cancel', [FormController::class, 'cancel_booking'])->name('booking.cancel');

Route::middleware(['auth'])->group(function () {
    Route::get('/my-calendar', [CalendarController::class, 'show'])->name('calendar.show');
});



// BAGIAN PSIKOLOG
Route::get('/login2', [SocialiteController::class, 'nonPasienLoginPage'])->name('nonPasien.loginpage');
Route::post('/login2', [SocialiteController::class, 'nonPasienLogin'])->name('auth.nonPasien');
Route::get('/home-psikolog', [AgendaController::class, 'homePsikolog'])->name('home.psikolog');
Route::get('/agenda-psikolog', [AgendaController::class, 'agendaPsikolog'])->name('agenda.psikolog');
Route::get('/agenda-psikolog/filter', [AgendaController::class, 'agendaPsikologFilterJadwal'])->name('agenda.psikolog.filter');
Route::post('/add-konsultasi', [AgendaController::class, 'addKonsultasi'])->name('add.konsultasi');
Route::post('/update-konsultasi', [AgendaController::class, 'updateKonsultasi'])->name('update.konsultasi');
Route::get('/logout2', [SocialiteController::class, 'nonPasienLogout'])->name('nonPasien.logout');

// ADMIN ROUTES
Route::middleware([AdminMiddleware::class, 'auth'])->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('psikologs', AdminPsikologController::class);
        Route::resource('jadwals', AdminJadwalController::class)->only(['index', 'create', 'store', 'destroy']);
        Route::resource('bookings', AdminBookingController::class)->only(['index', 'edit', 'update']);
    });
});
