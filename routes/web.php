<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request; // Pastikan baris ini ada

// ======================================================================
// 1. RUTE PUBLIK (Bebas Akses, Pasien Bisa Terserah Tanpa Login)
// ======================================================================
Route::get('/', [PasienController::class, 'index'])->name('pasien.index');
Route::post('/pasien/store', [PasienController::class, 'store'])->name('pasien.store');


// ======================================================================
// 2. RUTE OTENTIKASI (Menyuplai Parameter Role ke Controller Secara Akurat)
// ======================================================================

// --- Bagian Login Admin ---
Route::get('/login/admin', function () {
    return app(AuthController::class)->showLogin('admin');
})->name('login.admin');

Route::post('/login/admin', function (Request $request) {
    return app(AuthController::class)->login($request, 'admin');
});

// --- Bagian Login Staf ---
Route::get('/login/staff', function () {
    return app(AuthController::class)->showLogin('staff');
})->name('login.staff');

Route::post('/login/staff', function (Request $request) {
    return app(AuthController::class)->login($request, 'staff');
});

// --- Proses Logout ---
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// ======================================================================
// 3. RUTE TERPROTEKSI MIDDLEWARE (Wajib Login Internal)
// ======================================================================

// Khusus Akun Admin
// Ubah alamat menjadi '/admin/dashboard' dan namanya menjadi 'admin.dashboard'
Route::middleware(['role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::post('/admin/hitung/{id}', [AdminController::class, 'hitung'])->name('admin.hitung');
    Route::post('/admin/keputusan/{id}/{status}', [AdminController::class, 'keputusan'])->name('admin.keputusan');
});

// Khusus Akun Staff
Route::middleware(['role:staff'])->group(function () {
    Route::get('/staff', [StaffController::class, 'index'])->name('staff.index');
});

Route::middleware(['role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::post('/admin/hitung/{id}', [AdminController::class, 'hitung'])->name('admin.hitung');
    Route::post('/admin/keputusan/{id}/{status}', [AdminController::class, 'keputusan'])->name('admin.keputusan');
    
    // TAMBAHKAN BARIS BARU INI UNTUK PROSES HAPUS DATA
    Route::delete('/admin/pasien/hapus/{id}', [AdminController::class, 'destroy'])->name('admin.pasien.hapus');
});