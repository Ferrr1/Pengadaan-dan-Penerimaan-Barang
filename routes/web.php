<?php

use App\Http\Controllers\AnggaranController;
use App\Http\Controllers\KelAnggaranController;
use App\Http\Controllers\PermintaanPembelianController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RekananController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\SubAnggaranController;
use App\Http\Controllers\SubPermintaanPembelianController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserController;
use App\Models\SubPermintaan_Pembelian;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Users
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/show/{id}', [UserController::class, 'show'])->name('users.show');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Anggaran
    Route::resource('anggarans', AnggaranController::class);
    // Sub Anggaran
    Route::resource('subAnggarans', SubAnggaranController::class)->except(['store']);
    Route::post('/subAnggarans/{anggaran}', [SubAnggaranController::class, 'store'])->name('subAnggarans.store');
    // Kelompok Anggaran
    Route::resource('kelAnggarans', KelAnggaranController::class);
    // Transaksi
    Route::resource('transaksis', TransaksiController::class);
    // Permintaan Pembelian
    Route::resource('permintaanPembelians', PermintaanPembelianController::class);
    // Sub Permintaan Pembelian
    Route::resource('subPermintaanPembelians', SubPermintaanPembelianController::class)->except(['store']);
    Route::post('/subPermintaanPembelians/{subPermintaanPembelian}', [SubPermintaanPembelianController::class, 'store'])->name('subPermintaanPembelians.store');
    // Satuan
    Route::resource('satuans', SatuanController::class);
    // Projects
    Route::resource('projects', ProjectController::class);
    // Products
    Route::resource('products', ProdukController::class);
    // Rekanans
    Route::resource('suppliers', RekananController::class);
});

require __DIR__ . '/auth.php';
