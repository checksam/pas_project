<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\RekeningController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\TransferController;

/**
 * ROUTING & LOGIC HANDLING
 * Demonstrasi Penggunaan Resource Controller Routes
 * 
 * Setiap Route::resource() otomatis membuat 7 route CRUD:
 * - GET    /resource              -> index()      Menampilkan list
 * - GET    /resource/create       -> create()     Form buat baru
 * - POST   /resource              -> store()      Simpan ke DB
 * - GET    /resource/{id}         -> show()       Tampilkan detail
 * - GET    /resource/{id}/edit    -> edit()       Form edit
 * - PUT    /resource/{id}         -> update()     Update ke DB
 * - DELETE /resource/{id}         -> destroy()    Hapus dari DB
 */

// Dashboard / Home
Route::get('/', function () {
    return view('dashboard');
});

// Authentication
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/**
 * PEGAWAI ROUTES
 * Demonstrasi Resource Controller Pattern
 */
Route::resource('pegawai', PegawaiController::class);
Route::middleware('auth')->group(function () {
    Route::post('/pegawai', [PegawaiController::class, 'store']);
    Route::get('/pegawai/create', [PegawaiController::class, 'create']);
    Route::put('/pegawai/{pegawai}', [PegawaiController::class, 'update']);
    Route::get('/pegawai/{pegawai}/edit', [PegawaiController::class, 'edit']);
    Route::delete('/pegawai/{pegawai}', [PegawaiController::class, 'destroy']);
});

/**
 * REKENING ROUTES
 * Demonstrasi Resource Controller Pattern dengan relasi User
 */
Route::resource('rekening', RekeningController::class);
Route::middleware('auth')->group(function () {
    Route::post('/rekening', [RekeningController::class, 'store']);
    Route::get('/rekening/create', [RekeningController::class, 'create']);
    Route::put('/rekening/{rekening}', [RekeningController::class, 'update']);
    Route::get('/rekening/{rekening}/edit', [RekeningController::class, 'edit']);
    Route::delete('/rekening/{rekening}', [RekeningController::class, 'destroy']);
});

/**
 * TRANSAKSI ROUTES
 * Demonstrasi Resource Controller dengan Database Transaction
 * dan manipulasi data tingkat lanjut (CRUD + custom logic)
 */
Route::resource('transaksi', TransaksiController::class)->except(['edit', 'update']);
Route::middleware('auth')->group(function () {
    Route::post('/transaksi', [TransaksiController::class, 'store']);
    Route::get('/transaksi/create', [TransaksiController::class, 'create']);
    Route::delete('/transaksi/{transaksi}', [TransaksiController::class, 'destroy']);
});

/**
 * TRANSFER ROUTES
 * Demonstrasi Resource Controller dengan Multiple Relations
 * dan Business Logic kompleks
 */
Route::resource('transfer', TransferController::class);
Route::middleware('auth')->group(function () {
    Route::post('/transfer', [TransferController::class, 'store']);
    Route::get('/transfer/create', [TransferController::class, 'create']);
    Route::put('/transfer/{transfer}', [TransferController::class, 'update']);
    Route::get('/transfer/{transfer}/edit', [TransferController::class, 'edit']);
    Route::delete('/transfer/{transfer}', [TransferController::class, 'destroy']);
});
