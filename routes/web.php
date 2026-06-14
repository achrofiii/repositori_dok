<?php

use App\Http\Controllers\{
    SpkController,
    DashboardController,
    FakultasController,
    DokumenController,
    JurusanController,
    KategoriController,
    ProfileController,
    VerifikasiDokumenController,
    UserController,
    ForgotPasswordController
};
use App\Http\Controllers\landingpage\HomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// ===================== ROUTE PUBLIK =====================
Route::middleware('guest')->group(function () {
    // Landing Page
    Route::get('/', [HomeController::class, 'index'])->name('landingpage.home');
    Route::get('/documents', [HomeController::class, 'document'])->name('landingpage.documents');
    Route::get('/dokumen', [HomeController::class, 'search'])->name('dokumen.search');
    Route::get('/dokumen/download/{dokumen}', [DokumenController::class, 'download'])->name('dokumen.download');

    Route::prefix('password')
        ->name('password.')
        ->group(function () {
            Route::get('/forgot', [ForgotPasswordController::class, 'showEmailForm'])->name('request');
            Route::post('/send-otp', [ForgotPasswordController::class, 'sendOtp'])->name('send-otp');
            Route::get('/otp/{email}', [ForgotPasswordController::class, 'showOtpForm'])->name('otp-form');
            Route::post('/verify-otp', [ForgotPasswordController::class, 'verifyOtp'])->name('verify-otp');
            Route::get('/reset/{email}/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('reset-form');
            Route::post('/reset', [ForgotPasswordController::class, 'resetPassword'])->name('update');
            Route::post('/resend-otp', [ForgotPasswordController::class, 'resendOtp'])->name('resend-otp');
        });
});

// ===================== ROUTE YANG MEMBUTUHKAN LOGIN =====================
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        $role = Auth::user()->getRoleNames()->first();
        return redirect()->route('dashboard.role', ['role' => $role]);
    })->name('dashboard');
    Route::get('/dashboard-{role}', [DashboardController::class, 'show'])
        ->where('role', 'admin|dosen|mahasiswa')
        ->name('dashboard.role');

    // dokumen
    Route::get('/dokumens', [DokumenController::class, 'index'])->name('dokumen.index');
    Route::get('/get-jurusan/{fakultas_id}', [DokumenController::class, 'getJurusan']);
    Route::get('auth/dokumen/download/{dokumen}', [DokumenController::class, 'download'])->name('auth.dokumen.download');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::put('/profile/detail', [ProfileController::class, 'updateDetail'])->name('profile.detail');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ===================== ADMIN ROUTES =====================
    Route::prefix('admin')->middleware('role:admin')->group(function () {
        Route::middleware('can:kelola-kategori')->resource('kategori', KategoriController::class)->except(['create', 'edit', 'show']);
        Route::middleware('can:kelola-fakultas')->resource('fakultas', FakultasController::class)->except(['create', 'edit', 'show']);
        Route::middleware('can:kelola-prodi')->resource('jurusan', JurusanController::class)->except(['create', 'edit']);
        Route::middleware('can:kelola-user')->resource('custommer-service', UserController::class)->except(['create', 'edit', 'show']);
        Route::post('/import-users', [UserController::class, 'import'])->name('users.import');

        // Verifikasi dokumen dosen
        Route::middleware('can:verifikasi-dokumen')->get('/dokumen/verifikasi', [VerifikasiDokumenController::class, 'index'])->name('documents.verifikasi.index');
        Route::middleware('can:verifikasi-dokumen')->put('/dokumen/{dokumen}/verify', [VerifikasiDokumenController::class, 'verifyDosen'])->name('documents.verify.dosen');
        Route::middleware('can:verifikasi-dokumen')->put('/dokumen/{dokumen}/unverify', [VerifikasiDokumenController::class, 'unverify'])->name('documents.unverify.dosen');
        Route::get('/dokumen/{dokumen}', [VerifikasiDokumenController::class, 'show'])->name('documents.show');

        // SPK PROMETHEE
        Route::get('/spk', [SpkController::class, 'index'])->name('spk.index');
    });

    // ===================== DOSEN ROUTES =====================
    Route::prefix('dosen')->middleware('role:dosen')->group(function () {
        // CRUD dokumen (dosen)
        Route::middleware('can:upload-dokumen')->get('/dokumen/create', [DokumenController::class, 'create'])->name('documents.create');
        Route::middleware('can:upload-dokumen')->post('/documents', [DokumenController::class, 'store'])->name('documents.store');
        Route::middleware('can:edit-dokumen')->get('/documents/{dokumen}/edit', [DokumenController::class, 'edit'])->name('documents.edit');
        Route::middleware('can:edit-dokumen')->put('/documents/{dokumen}', [DokumenController::class, 'update'])->name('documents.update');
        Route::middleware('can:hapus-dokumen')->delete('/documents/{document}', [DokumenController::class, 'destroy'])->name('documents.destroy');

        // Verifikasi dokumen mahasiswa bimbingan
        Route::middleware('can:verifikasi-dokumen-mahasiswa')->get('/dokumen/verifikasi', [VerifikasiDokumenController::class, 'index'])->name('dosen.documents.verifikasi.index');
        Route::middleware('can:verifikasi-dokumen-mahasiswa')->put('/dokumen/{dokumen}/verify', [VerifikasiDokumenController::class, 'verifyMahasiswa'])->name('documents.verify.mahasiswa');
        Route::middleware('can:verifikasi-dokumen-mahasiswa')->put('/dokumen/{dokumen}/unverify', [VerifikasiDokumenController::class, 'unverify'])->name('documents.unverify.mahasiswa');
    });

    // ===================== MAHASISWA ROUTES =====================
    Route::prefix('mahasiswa')->middleware('role:mahasiswa')->group(function () {
        // CRUD dokumen (mahasiswa)
        Route::get('/dokumen', [DokumenController::class, 'index'])->name('mahasiswa.dokumen.index');
        Route::middleware('can:upload-dokumen')->get('/dokumen/create', [DokumenController::class, 'create'])->name('mahasiswa.documents.create');
        Route::middleware('can:upload-dokumen')->post('/documents', [DokumenController::class, 'store'])->name('mahasiswa.documents.store');
        Route::middleware('can:edit-dokumen')->get('/documents/{dokumen}/edit', [DokumenController::class, 'edit'])->name('mahasiswa.documents.edit');
        Route::middleware('can:edit-dokumen')->put('/documents/{dokumen}', [DokumenController::class, 'update'])->name('mahasiswa.documents.update');
        Route::middleware('can:hapus-dokumen')->delete('/documents/{document}', [DokumenController::class, 'destroy'])->name('mahasiswa.documents.destroy');
        Route::get('/dokumen/unduh/{token}', [DokumenController::class, 'unduh'])->name('dokumen.unduh');
    });
});

require __DIR__ . '/auth.php';
