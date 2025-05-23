<?php

use App\Models\Barang;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\ProfileController;

// Halaman utama
Route::get('/', function () {
    $barangs = Barang::latest()->take(4)->get(); // Ambil 4 barang terbaru
    return view('home', compact('barangs'));
})->name('home');

// Dashboard (hanya untuk user login dan terverifikasi)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

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

});

// menampilkan deskrisi barang
Route::get('/barang/{barang}', [BarangController::class, 'show'])->name('barang.show');


require __DIR__.'/auth.php';
