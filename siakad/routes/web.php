<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// ✅ ROOT → SELALU KE LOGIN
Route::get('/', function () {
    return redirect('/login');
});

// 🔒 AUTH
Route::middleware('auth')->group(function(){

    // ✅ FIX: redirect sesuai role (INI KUNCI UTAMA)
    Route::get('/dashboard', function () {
        if (auth()->user()->level === 1) return redirect('/admin');
        if (auth()->user()->level === 2) return redirect('/kaprodi');
        if (auth()->user()->level === 3) return redirect('/mahasiswa');
    })->name('dashboard');

    Route::delete('/logout', [LoginController::class, 'destroy']);

    Route::get('/admin', function(){
        return view('admin.dashboard');
    });

    Route::get('/admin/kelola-user', [UserController::class, 'index']);
    Route::get('/admin/kelola-user/create', [UserController::class, 'create']);
    Route::post('/admin/kelola-user/create', [UserController::class, 'store']);
    Route::delete('/admin/kelola-user/{user}', [UserController::class, 'destroy']);
    
    Route::get('/kaprodi', function(){
        return view('kaprodi.dashboard');
    });

    Route::get('/kaprodi/kelola_jadwal', function () {
        return view('kaprodi.kelola_jadwal.index');
    })->name('kaprodi.jadwal');

    Route::get('/mahasiswa', function(){
        return view('mahasiswa.dashboard');
    });

    Route::get('/mahasiswa/penawaran', function(){
        return view('mahasiswa.penawaran.index', [
            'jadwals' => \App\Models\Jadwal::all()
        ]);
    });

    Route::get('/mahasiswa/view_krs', function(){
        return view('mahasiswa.kartu_KRS.index');
    });
});

// 🔓 GUEST
Route::middleware('guest')->group(function(){
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
});