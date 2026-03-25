<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Guest\HomeController;
use App\Http\Controllers\Guest\BeritaController;
use App\Http\Controllers\Guest\ProfileController;
use App\Http\Controllers\Guest\AnggotaController;
use App\Http\Controllers\Guest\DonasiController;
use App\Http\Controllers\Guest\PerizinanController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\MidtransCallbackController;
use App\Models\Mitra;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/*
 |--------------------------------------------------------------------------
 | Midtrans Webhook (CSRF-excluded in bootstrap/app.php)
 |--------------------------------------------------------------------------
 */
Route::post('/midtrans/callback', [MidtransCallbackController::class , 'handle'])
    ->name('midtrans.callback');

/*
 |--------------------------------------------------------------------------
 | Public Routes
 |--------------------------------------------------------------------------
 */

Route::get('/', [HomeController::class , 'index'])->name('home');
Route::get('/berita', [BeritaController::class , 'index'])->name('berita.index');
Route::get('/berita/{slug}', [BeritaController::class , 'show'])->name('berita.show');
Route::get('/kegiatan', [BeritaController::class , 'kegiatan'])->name('kegiatan.index');
Route::get('/kegiatan/{slug}', [BeritaController::class , 'showKegiatan'])->name('kegiatan.show');
Route::get('/profil', [ProfileController::class , 'index'])->name('profil.index');
Route::get('/anggota', [AnggotaController::class , 'index'])->name('anggota.index');
Route::get('/donasi', [DonasiController::class , 'index'])->name('donasi.index');
Route::get('/donasi/{slug}', [DonasiController::class , 'show'])->name('donasi.show');
Route::get('/perizinan', [PerizinanController::class , 'form'])->name('perizinan.form');
Route::post('/perizinan', [PerizinanController::class , 'submit'])->name('perizinan.submit');
Route::get('/perizinan/cek', [PerizinanController::class , 'cek'])->middleware('throttle:10,1')->name('perizinan.cek');
Route::get('/mitra', fn() => view('public.mitra.index'))->name('mitra.index');

/*
 |--------------------------------------------------------------------------
 | Auth Routes
 |--------------------------------------------------------------------------
 */

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class , 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class , 'login'])->middleware('throttle:5,1');
    Route::get('/register', [RegisterController::class , 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class , 'register']);
    Route::get('/forgot-password', [ForgotPasswordController::class , 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class , 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [ForgotPasswordController::class , 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ForgotPasswordController::class , 'reset'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class , 'logout'])->name('logout');
    Route::get('/email/verify', [VerificationController::class , 'notice'])->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [VerificationController::class , 'verify'])
        ->middleware('signed')->name('verification.verify');
    Route::post('/email/verification-notification', [VerificationController::class , 'resend'])
        ->middleware('throttle:6,1')->name('verification.send');
});

/*
 |--------------------------------------------------------------------------
 | Admin Routes
 |--------------------------------------------------------------------------
 */

Route::prefix('admin')->name('admin.')->middleware(['auth', 'is-admin'])->group(function () {
    Route::get('/', [DashboardController::class , 'index'])->name('dashboard');

    Route::get('/berita', fn() => view('admin.berita.index'))->name('berita.index');
    Route::get('/kategori', fn() => view('admin.kategori.index'))->name('kategori.index');
    Route::get('/users', fn() => view('admin.users.index'))->name('users.index');
    Route::get('/sliders', fn() => view('admin.sliders.index'))->name('sliders.index');
    Route::get('/perizinan', fn() => view('admin.perizinan.index'))->name('perizinan.index');
    Route::get('/program-donasi', fn() => view('admin.program-donasi.index'))->name('program-donasi.index');
    Route::get('/transaksi-donasi', fn() => view('admin.transaksi-donasi.index'))->name('transaksi-donasi.index');
    Route::get('/mitra', fn() => view('admin.mitra.index'))->name('mitra.index');
    Route::get('/profil', fn() => view('admin.profil.index'))->name('profil.index');
    Route::get('/audit-log', fn() => view('admin.audit-log.index'))->name('audit-log.index');
    Route::get('/anggota', fn() => view('admin.anggota.index'))->name('anggota.index');

    // Download private mitra documents
    Route::get('/mitra/{mitra}/dokumen/{type}', function (Mitra $mitra, string $type) {
            $path = $type === 'npwp' ? $mitra->dokumen_npwp : $mitra->dokumen_legalitas;
            abort_unless($path && Storage::disk('local')->exists($path), 404);

            $extension = pathinfo($path, PATHINFO_EXTENSION) ?: 'pdf';
            $label = $type === 'npwp' ? 'dokumen_npwp' : 'dokumen_legalitas';
            $safeName = Str::slug($mitra->nama_perusahaan);
            $displayName = "{$label}_{$safeName}.{$extension}";

            return Storage::disk('local')->response($path, $displayName);
        }
        )->name('mitra.dokumen')->where('type', 'npwp|legalitas');

    // Download private perizinan documents
    Route::get('/perizinan/{perizinan}/dokumen/{index}', function (App\Models\Perizinan $perizinan, int $index) {
            $docs = $perizinan->dokumen_pendukung ?? [];
            abort_unless(isset($docs[$index]), 404);
            $path = $docs[$index];
            abort_unless(Storage::disk('local')->exists($path), 404);

            $extension = pathinfo($path, PATHINFO_EXTENSION) ?: 'pdf';
            $displayName = "dokumen_perizinan_{$perizinan->id}_" . ($index + 1) . ".{$extension}";

            return Storage::disk('local')->response($path, $displayName);
        })->name('perizinan.dokumen');
    });

// ── Mitra Panel ──
Route::prefix('mitra-panel')->name('mitra.')->middleware(['auth', 'is-mitra'])->group(function () {
    Route::get('/', fn() => view('mitra.dashboard.index'))->name('dashboard');
    Route::get('/program-donasi', fn() => view('mitra.program-donasi.index'))->name('program-donasi.index');
    Route::get('/berita', fn() => view('mitra.berita.index'))->name('berita.index');
});