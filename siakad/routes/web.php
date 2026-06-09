<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\PerwalianController;
use App\Http\Controllers\UbahPasswordController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Kaprodi\JadwalController;
use App\Http\Controllers\Kaprodi\PenawaranController;
use App\Http\Controllers\Admin\MkController;
use App\Http\Controllers\Admin\DosenController;
use App\Http\Controllers\Admin\ProdiController;
use App\Http\Controllers\FakultasController;
use App\Http\Controllers\KurikulumController;

use App\Http\Controllers\Mahasiswa\MataKuliahController;
use App\Http\Controllers\Mahasiswa\PenawaranMahasiswaController;
use App\Http\Controllers\Mahasiswa\KrsMahasiswaController;
use App\Http\Controllers\Mahasiswa\DetailMataKuliahController;

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware('auth')->group(function () {

    // =========================
    // LOGOUT
    // =========================
    Route::delete('/logout', [LoginController::class, 'destroy']);

    // =========================
    // ADMIN
    // =========================
    Route::get('/admin', function () {
        return view('admin.dashboard');
    });

    Route::get('/admin/kelola-user', [UserController::class, 'index']);
    Route::get('/admin/kelola-user/create', [UserController::class, 'create']);
    Route::post('/admin/kelola-user', [UserController::class, 'store']);
    Route::delete('/admin/kelola-user/{user}', [UserController::class, 'destroy']);
    Route::get('/admin/kelola-user/{user}/edit', [UserController::class, 'edit']);
    Route::patch('/admin/kelola-user/{user}', [UserController::class, 'update']);

    Route::get('/admin/kelola-kurikulum', [KurikulumController::class, 'index']);
    Route::get('/admin/kelola-kurikulum/create', [KurikulumController::class, 'create']);
    Route::post('/admin/kelola-kurikulum', [KurikulumController::class, 'store']);
    Route::get('/admin/kelola-kurikulum/{kurikulum}', [KurikulumController::class, 'show']);
    Route::get('/admin/kelola-kurikulum/{kurikulum}/edit', [KurikulumController::class, 'edit']);
    Route::patch('/admin/kelola-kurikulum/{kurikulum}', [KurikulumController::class, 'update']);
    Route::delete('/admin/kelola-kurikulum/{kurikulum}', [KurikulumController::class, 'destroy']);
    
    
    Route::get('/admin/kelola-matakuliah', [MkController::class, 'index']);
    Route::get('/admin/kelola-matakuliah/create', [MkController::class, 'create']);
    Route::post('/admin/kelola-matakuliah', [MkController::class, 'store']);
    Route::get('/admin/kelola-matakuliah/{mk}', [MkController::class, 'show']);
    Route::get('/admin/kelola-matakuliah/{mk}/edit', [MkController::class, 'edit']);
    Route::patch('/admin/kelola-matakuliah/{mk}', [MkController::class, 'update']);
    Route::delete('/admin/kelola-matakuliah/{mk}', [MkController::class, 'destroy']);
    
    Route::get('/admin/kelola-dosen', [DosenController::class, 'index']);
    Route::get('/admin/kelola-dosen/create', [DosenController::class, 'create']);
    Route::post('/admin/kelola-dosen', [DosenController::class, 'store']);
    Route::get('/admin/kelola-dosen/{dosen}/edit', [DosenController::class, 'edit']);
    Route::patch('/admin/kelola-dosen/{dosen}', [DosenController::class, 'update']);
    Route::delete('/admin/kelola-dosen/{dosen}', [DosenController::class, 'destroy']);
 
    
    Route::get('/admin/kelola-prodi', [ProdiController::class, 'index']);
    Route::get('/admin/kelola-prodi/create', [ProdiController::class, 'create']);
    Route::post('/admin/kelola-prodi', [ProdiController::class, 'store']);
    Route::get('/admin/kelola-prodi/{prodi}/edit', [ProdiController::class, 'edit']);
    Route::patch('/admin/kelola-prodi/{prodi}', [ProdiController::class, 'update']);
    Route::delete('/admin/kelola-prodi/{prodi}', [ProdiController::class, 'destroy']);

    Route::get('/admin/kelola-fakultas', [FakultasController::class, 'index']);
    Route::get('/admin/kelola-fakultas/create', [FakultasController::class, 'create']);
    Route::post('/admin/kelola-fakultas', [FakultasController::class, 'store']);
    Route::get('/admin/kelola-fakultas/{fakultas}/edit', [FakultasController::class, 'edit']);
    Route::patch('/admin/kelola-fakultas/{fakultas}', [FakultasController::class, 'update']);
    Route::delete('/admin/kelola-fakultas/{fakultas}', [FakultasController::class, 'destroy']);

    
 
    // =========================
    // DASHBOARD KAPRODI
    // =========================
    Route::get('/kaprodi', function () {
        return view('kaprodi.dashboard');
    });

    // =========================
    // KAPRODI - JADWAL
    // =========================
    Route::prefix('kaprodi')->group(function () {

        // 🔥 semua jadwal
        Route::get('/kelola_jadwal', [JadwalController::class, 'index'])
            ->name('jadwal.index');

        // 🔥 JADWAL PAGI
        Route::get('/jadwal_pagi', [JadwalController::class, 'pagi'])
            ->name('jadwal.pagi');

        // 🔥 JADWAL MALAM
        Route::get('/jadwal_malam', [JadwalController::class, 'malam'])
            ->name('jadwal.malam');

        // 🔥 detail jadwal + mahasiswa
        Route::get('/kelola_jadwal/{recno}', [JadwalController::class, 'show'])
            ->name('kaprodi.jadwal.show');

        // create
        Route::get('/kelola_jadwal/buat', [JadwalController::class, 'create'])
            ->name('jadwal.buat');

        // store
        Route::post('/kelola_jadwal/store', [JadwalController::class, 'store'])
            ->name('jadwal.store');

        // edit
        Route::get('/kelola_jadwal/edit/{id}', [JadwalController::class, 'edit'])
            ->name('jadwal.edit');

        // update
        Route::post('/kelola_jadwal/update/{id}', [JadwalController::class, 'update'])
            ->name('jadwal.update');

        // delete
        Route::delete('/kelola_jadwal/delete/{id}', [JadwalController::class, 'destroy'])
            ->name('jadwal.destroy');
    });
    // =========================
    // KAPRODI - PENAWARAN
    // =========================
    Route::prefix('kaprodi')->group(function () {

        // form utama
    
        Route::get('/penawaran', [PenawaranController::class, 'index'])
            ->name('kaprodi.penawaran.index');
        // create
        Route::get('/penawaran/create', [PenawaranController::class, 'create'])
            ->name('kaprodi.penawaran.create');

        // store
        Route::post('/penawaran/store', [PenawaranController::class, 'store'])
            ->name('kaprodi.penawaran.store');

        // edit
        Route::get('/penawaran/{recno}/edit', [PenawaranController::class, 'edit'])
            ->name('kaprodi.penawaran.edit');

        // update
        Route::put('/penawaran/{recno}', [PenawaranController::class, 'update'])
            ->name('kaprodi.penawaran.update');

        // delete
        Route::delete('/penawaran/delete/{recno}', [PenawaranController::class, 'destroy'])
            ->name('kaprodi.penawaran.delete');
    });

    // =========================
    // MAHASISWA
    // =========================
    Route::get('/mahasiswa', function () {
        return view('mahasiswa.dashboard');
    });

    Route::get('/mahasiswa/view_krs', function () {
        return view('mahasiswa.kartu_KRS.index');
    });

    Route::get('/mahasiswa/ubah-password', [UbahPasswordController::class, 'create']);
    Route::patch('/mahasiswa/ubah-password', [UbahPasswordController::class, 'store']);

    // =========================
    // DOSEN
    // =========================
    Route::get('/dosen-wali', function () {
        return view('dosen.dashboard');
    });

    Route::get('/dosen-wali/perwalian', [PerwalianController::class, 'index']);


    // =========================
    // MAHASISWA
    // =========================
    Route::get('/mahasiswa', function(){
        return view('mahasiswa.dashboard');
    });
    
    Route::get('/mahasiswa/penawaran', [PenawaranMahasiswaController::class, 'index']);
    Route::get('/mahasiswa/view_krs', function(){
        return view('mahasiswa.kartu_KRS.index');
    });
    Route::get('/mahasiswa/nilai_krs', function(){
        return view('mahasiswa.nilai_krs.index');
    });
    Route::get('/mahasiswa/KHS', function(){
        return view('mahasiswa.KHS.index');
    });
    Route::get('/mahasiswa/Transkrip_Nilai', function(){
        return view('mahasiswa.Transkrip_Nilai.index');
    });

    Route::prefix('mahasiswa')->group(function () {
    Route::get('/krs', [KrsMahasiswaController::class, 'index'])->name('mahasiswa.krs.index');
    Route::post('/krs', [KrsMahasiswaController::class, 'store'])->name('mahasiswa.krs.store'); // <-- tambah ini
    Route::delete('/krs/{id}', [KrsMahasiswaController::class, 'destroy'])->name('mahasiswa.krs.destroy');
    Route::delete('/krs/batal-multiple', [KrsMahasiswaController::class, 'batalMultiple'])->name('mahasiswa.krs.batal');
    });

    Route::get('/mahasiswa/mata-kuliah/{id}', [DetailMataKuliahController::class, 'show'])->name('mata-kuliah.show');
    Route::get('/mahasiswa/ubah-password', [UbahPasswordController::class, 'edit']);
    Route::patch('/mahasiswa/ubah-password/{user}', [UbahPasswordController::class, 'update']);
});

// =========================
// GUEST
// =========================
Route::middleware('guest')->group(function () {

    Route::get('/login', [LoginController::class, 'create'])
        ->name('login');

    Route::post('/login', [LoginController::class, 'store']);
});