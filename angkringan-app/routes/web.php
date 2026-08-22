<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\MenuController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Untuk sementara kita biarkan tanpa middleware auth agar mudah dites
// Nanti setelah tampilan selesai, kita bisa bungkus route ini dengan middleware auth

// Route Dashboard (Menggantikan index.php)
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Route Input Stok (Menggantikan input_stok.php)
Route::get('/input-stok', [StokController::class, 'index'])->name('stok.index');
Route::post('/input-stok', [StokController::class, 'simpan'])->name('stok.simpan');

// Route Manajemen Menu (Menggantikan manajemen_menu.php)
Route::get('/manajemen-menu', [MenuController::class, 'index'])->name('manajemen.menu');
Route::post('/manajemen-menu/kategori', [MenuController::class, 'simpanKategori'])->name('kategori.simpan');
Route::get('/manajemen-menu/kategori/hapus/{id}', [MenuController::class, 'hapusKategori'])->name('kategori.hapus');

Route::post('/manajemen-menu/menu', [MenuController::class, 'simpanMenu'])->name('menu.simpan');
Route::get('/manajemen-menu/menu/hapus/{id}', [MenuController::class, 'hapusMenu'])->name('menu.hapus');