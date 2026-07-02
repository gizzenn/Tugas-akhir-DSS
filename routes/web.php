<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StaffController;

Route::get('/', [PasienController::class, 'index'])->name('pasien.index');
Route::post('/pasien/store', [PasienController::class, 'store'])->name('pasien.store');

Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
Route::post('/admin/hitung/{id}', [AdminController::class, 'hitung'])->name('admin.hitung');
Route::post('/admin/keputusan/{id}/{status}', [AdminController::class, 'keputusan'])->name('admin.keputusan');

Route::get('/staff', [StaffController::class, 'index'])->name('staff.index');