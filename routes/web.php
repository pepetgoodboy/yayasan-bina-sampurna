<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\JenisPembayaranController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/register', function () {
    return redirect()->route('register');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard/download-pdf', [DashboardController::class, 'downloadPDF'])
    ->middleware(['auth', 'role:ortu'])->name('dashboard.download-pdf');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Admin & Bendahara routes
Route::middleware(['auth', 'role:admin,bendahara'])->group(function () {
    Route::get('pembayaran/sisa-tagihan', [PembayaranController::class, 'getSisaTagihan'])->name('pembayaran.sisa-tagihan');
    Route::get('pembayaran/jenis-by-siswa', [PembayaranController::class, 'getJenisPembayaranBySiswa'])->name('pembayaran.jenis-by-siswa');
    Route::resource('kelas', KelasController::class);
    Route::resource('siswa', SiswaController::class);
    Route::get('siswa-export-excel', [SiswaController::class, 'exportExcel'])->name('siswa.export-excel');
    Route::resource('jenis-pembayaran', JenisPembayaranController::class);
    Route::resource('pembayaran', PembayaranController::class);
    
    Route::get('laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('laporan/export-pdf', [LaporanController::class, 'exportPDF'])->name('laporan.export-pdf');
    Route::get('laporan/export-excel', [LaporanController::class, 'exportExcel'])->name('laporan.export-excel');
});

// Admin only routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('users', UserController::class);
});

require __DIR__.'/auth.php';
