<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\PerwalianController;
use App\Http\Controllers\UbahPasswordController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Kaprodi\JadwalController;

Route::get('/', function () {
    return redirect('/login');
});


Route::middleware('auth')->group(function(){

    Route::delete('/logout', [LoginController::class, 'destroy']);

    Route::get('/admin', function(){
        return view('admin.dashboard');
    });

    Route::get('/admin/kelola-user', [UserController::class, 'index']);
    Route::get('/admin/kelola-user/create', [UserController::class, 'create']);
    Route::post('/admin/kelola-user/create', [UserController::class, 'store']);
    Route::delete('/admin/kelola-user/{user}', [UserController::class, 'destroy']);
    Route::get('/admin/kelola-user/{user}/edit', [UserController::class, 'edit']);
    Route::patch('/admin/kelola-user/{user}', [UserController::class, 'update']);
    
    Route::get('/kaprodi', function(){
        return view('kaprodi.dashboard');
    });

    // =========================
    // KAPRODI - JADWAL
    // =========================

    Route::get('/kaprodi/kelola_jadwal', [JadwalController::class, 'index'])->name('jadwal.index');

    Route::get('/kaprodi/kelola_jadwal/buat', [JadwalController::class, 'create'])->name('jadwal.buat');

    Route::post('/kaprodi/kelola_jadwal/store', [JadwalController::class, 'store'])->name('jadwal.store');
    
    Route::get('/kaprodi/kelola_jadwal/edit/{id}', [JadwalController::class, 'edit']);

    Route::post('/kaprodi/kelola_jadwal/update/{id}', [JadwalController::class, 'update']);

    Route::delete('/kaprodi/kelola_jadwal/delete/{id}', [JadwalController::class, 'destroy']);

    Route::get('/mahasiswa/view_krs', function(){
        return view('mahasiswa.kartu_KRS.index');
    });
    Route::get('/mahasiswa/ubah-password', [UbahPasswordController::class, 'edit']);
    Route::patch('/mahasiswa/ubah-password/{user}', [UbahPasswordController::class, 'update']);
    


    Route::get('/dosen', function(){
        return view('dosen.dashboard');
    });

    Route::get('/dosen/perwalian', [PerwalianController::class, 'index']);
    
});

// 🔓 GUEST
Route::middleware('guest')->group(function(){
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
});