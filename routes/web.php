<?php

use App\Models\Barang;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;



// Halaman utama
Route::get('/', [BerandaController::class, 'index'])->name('home');

// Dashboard Pengguna
Route::get('/dashboard', [UserDashboardController::class, 'index']) // <-- UBAH INI
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Barang index (publik boleh lihat semua laporan barang)
Route::get('/barang', [BarangController::class, 'index'])->name('barang.index');

// Grup route untuk user login
Route::middleware(['auth'])->group(function () {
    // Profil pengguna
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Barang CRUD (selain index, karena index publik)
    Route::get('/barang/create', [BarangController::class, 'create'])->name('barang.create');
    Route::post('/barang', [BarangController::class, 'store'])->name('barang.store');
    Route::get('/barang/{barang}/edit', [BarangController::class, 'edit'])->name('barang.edit');
    Route::put('/barang/{barang}', [BarangController::class, 'update'])->name('barang.update');
    Route::delete('/barang/{barang}', [BarangController::class, 'destroy'])->name('barang.destroy');
    Route::patch('/barang/{barang}/ubah-status', [BarangController::class, 'ubahStatus'])->name('barang.ubahStatus');
    Route::patch('/barang/{barang}/tandai-selesai', [BarangController::class, 'tandaiSelesai'])->name('barang.tandaiSelesai'); // <-- INI JALAN BARUNYA!

});

// GRUP RUTE ADMIN
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Rute untuk dashboard admin
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    // Rute baru untuk mengelola pengguna
    Route::get('/user', [AdminUserController::class, 'index'])->name('user.index');
    Route::patch('/user/{user}/toggle-admin', [AdminUserController::class, 'toggleAdmin'])->name('user.toggleAdmin');
    Route::delete('/user/{user}', [AdminUserController::class, 'destroy'])->name('user.destroy');
});

// menampilkan deskrisi barang
Route::get('/barang/{barang}', [BarangController::class, 'show'])->name('barang.show');


require __DIR__ . '/auth.php';
