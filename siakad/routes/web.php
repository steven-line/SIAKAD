<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware('auth')->group(function(){
        
    Route::get('/home', function() {
        return view('home');
    });
    Route::delete('/logout', [LoginController::class, 'destroy']);
    Route::get('/admin', function(){
        return view('admin.dashboard');
    });
    Route::get('/admin/kelola-user', [UserController::class, 'index']);
    Route::get('/admin/kelola-user/create', [UserController::class, 'create']);
    Route::get('/kaprodi', function(){
        return view('kaprodi.dashboard');
    });
    Route::get('/kaprodi/jadwal', function(){
        return view('kaprodi.jadwal');
    });

    Route::get('/mahasiswa', function(){
        return view('mahasiswa.dashboard');
    });
    Route::get('/mahasiswa/penawaran', function(){
        return view('mahasiswa.penawaran.index', [
            'jadwals' => \App\Models\Jadwal::all()
        ]);
    });
    Route::get('/mahasiswa/view_krs', function(){
        return view('mahasiswa.kartu_KRS.index', [
        ]);
    });
    Route::get('/mahasiswa/KHS', function(){
        return view('mahasiswa.KHS.index', [
        ]);
    });

    Route::get('/mahasiswa/Nilai_KRS', function(){
        return view('mahasiswa.Nilai_KRS.index', [
        ]);
    });

    Route::get('/mahasiswa/Transkrip_nilai', function(){
        return view('mahasiswa.Transkrip_nilai.index', [
        ]);
    });
});

Route::middleware('guest')->group(function(){
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
});