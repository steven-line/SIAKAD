<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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
});
Route::middleware('guest')->group(function(){
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
});


