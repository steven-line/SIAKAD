<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{
    LoginController,
    UserController,
    RoleController,
    PermissionController,
    PerwalianController,
    UbahPasswordController,
    FakultasController,
    KurikulumController,
    KrsController,
};

use App\Http\Controllers\Admin\{
    BiodataAdminController,
    MkController,
    ProdiController,
    DosenController,
};

use App\Http\Controllers\Kaprodi\{
    JadwalController,
    PenawaranController
};

use App\Http\Controllers\Mahasiswa\{
    PenawaranMahasiswaController,
    KrsMahasiswaController,
    NilaiKrsMahasiswaController,
    DetailMataKuliahController,
    BiodataMahasiswaController
};

/*
|--------------------------------------------------------------------------
| ROOT
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => redirect()->route('login'));

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::delete('/logout', [LoginController::class, 'destroy'])
        ->name('logout');

    Route::get('/dashboard', fn () => view('dashboard'))
        ->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | USERS
    |--------------------------------------------------------------------------
    */
    Route::prefix('users')
        ->middleware('permission:user.manage')
        ->name('users.')
        ->group(function () {

            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/create', [UserController::class, 'create'])->name('create');
            Route::post('/', [UserController::class, 'store'])->name('store');
            Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
            Route::patch('/{user}', [UserController::class, 'update'])->name('update');
            Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
        });

    /*
    |--------------------------------------------------------------------------
    | KURIKULUM
    |--------------------------------------------------------------------------
    */
    Route::prefix('kurikulum')
        ->middleware('permission:kurikulum.manage')
        ->name('kurikulum.')
        ->group(function () {

            Route::get('/', [KurikulumController::class, 'index'])->name('index');
            Route::get('/create', [KurikulumController::class, 'create'])->name('create');
            Route::post('/', [KurikulumController::class, 'store'])->name('store');
            Route::get('/{kurikulum}', [KurikulumController::class, 'show'])->name('show');
            Route::get('/{kurikulum}/edit', [KurikulumController::class, 'edit'])->name('edit');
            Route::patch('/{kurikulum}', [KurikulumController::class, 'update'])->name('update');
            Route::delete('/{kurikulum}', [KurikulumController::class, 'destroy'])->name('destroy');
        });

    /*
    |--------------------------------------------------------------------------
    | MATA KULIAH
    |--------------------------------------------------------------------------
    */
    Route::prefix('matakuliah')
        ->middleware('permission:mk.manage')
        ->name('mk.')
        ->group(function () {

            Route::get('/', [MkController::class, 'index'])->name('index');
            Route::get('/create', [MkController::class, 'create'])->name('create');
            Route::post('/', [MkController::class, 'store'])->name('store');
            Route::get('/{mk}', [MkController::class, 'show'])->name('show');
            Route::get('/{mk}/edit', [MkController::class, 'edit'])->name('edit');
            Route::patch('/{mk}', [MkController::class, 'update'])->name('update');
            Route::delete('/{mk}', [MkController::class, 'destroy'])->name('destroy');
        });

    /*
    |--------------------------------------------------------------------------
    | DOSEN
    |--------------------------------------------------------------------------
    */
    Route::prefix('dosen')
        ->middleware('permission:dosen.manage')
        ->name('dosen.')
        ->group(function () {

            Route::get('/', [DosenController::class, 'index'])->name('index');
            Route::get('/create', [DosenController::class, 'create'])->name('create');
            Route::post('/', [DosenController::class, 'store'])->name('store');
            Route::get('/{dosen}/edit', [DosenController::class, 'edit'])->name('edit');
            Route::patch('/{dosen}', [DosenController::class, 'update'])->name('update');
            Route::delete('/{dosen}', [DosenController::class, 'destroy'])->name('destroy');
        });

    /*
    |--------------------------------------------------------------------------
    | PRODI
    |--------------------------------------------------------------------------
    */
    Route::prefix('prodi')
        ->middleware('permission:prodi.manage')
        ->name('prodi.')
        ->group(function () {

            Route::get('/', [ProdiController::class, 'index'])->name('index');
            Route::get('/create', [ProdiController::class, 'create'])->name('create');
            Route::post('/', [ProdiController::class, 'store'])->name('store');
            Route::get('/{prodi}/edit', [ProdiController::class, 'edit'])->name('edit');
            Route::patch('/{prodi}', [ProdiController::class, 'update'])->name('update');
            Route::delete('/{prodi}', [ProdiController::class, 'destroy'])->name('destroy');
        });

    /*
    |--------------------------------------------------------------------------
    | FAKULTAS
    |--------------------------------------------------------------------------
    */
    Route::prefix('fakultas')
        ->middleware('permission:fakultas.manage')
        ->name('fakultas.')
        ->group(function () {

            Route::get('/', [FakultasController::class, 'index'])->name('index');
            Route::get('/create', [FakultasController::class, 'create'])->name('create');
            Route::post('/', [FakultasController::class, 'store'])->name('store');
            Route::get('/{fakultas}/edit', [FakultasController::class, 'edit'])->name('edit');
            Route::patch('/{fakultas}', [FakultasController::class, 'update'])->name('update');
            Route::delete('/{fakultas}', [FakultasController::class, 'destroy'])->name('destroy');
        });

    /*
    |--------------------------------------------------------------------------
    | BIODATA ADMIN
    |--------------------------------------------------------------------------
    */
    Route::prefix('biodata')
        ->middleware('permission:biodata.manage')
        ->name('biodata.')
        ->group(function () {

            Route::get('/', [BiodataAdminController::class, 'index'])->name('index');
            Route::get('/create', [BiodataAdminController::class, 'create'])->name('create');
            Route::get('/{biodata}', [BiodataAdminController::class, 'show'])->name('show');
            Route::post('/', [BiodataAdminController::class, 'store'])->name('store');
            Route::get('/{biodata}/edit', [BiodataAdminController::class, 'edit'])->name('edit');
            Route::put('/{biodata}', [BiodataAdminController::class, 'update'])->name('update');
            Route::delete('/{biodata}', [BiodataAdminController::class, 'destroy'])->name('destroy');
        });

    /*
    |--------------------------------------------------------------------------
    | ROLES
    |--------------------------------------------------------------------------
    */
    Route::prefix('roles')
        ->middleware('permission:role.manage')
        ->name('roles.')
        ->group(function () {

            Route::get('/', [RoleController::class, 'index'])->name('index');
            Route::get('/create', [RoleController::class, 'create'])->name('create');
            Route::post('/', [RoleController::class, 'store'])->name('store');
            Route::get('/{role}/edit', [RoleController::class, 'edit'])->name('edit');
            Route::patch('/{role}', [RoleController::class, 'update'])->name('update');
            Route::delete('/{role}', [RoleController::class, 'destroy'])->name('destroy');
        });

    /*
    |--------------------------------------------------------------------------
    | PERMISSIONS
    |--------------------------------------------------------------------------
    */
    Route::prefix('permissions')
        ->middleware('permission:permission.manage')
        ->name('permissions.')
        ->group(function () {

            Route::get('/', [PermissionController::class, 'index'])->name('index');
            Route::get('/create', [PermissionController::class, 'create'])->name('create');
            Route::post('/', [PermissionController::class, 'store'])->name('store');
            Route::get('/{permission}/edit', [PermissionController::class, 'edit'])->name('edit');
            Route::patch('/{permission}', [PermissionController::class, 'update'])->name('update');
            Route::delete('/{permission}', [PermissionController::class, 'destroy'])->name('destroy');
        });

    /*
    |--------------------------------------------------------------------------
    | JADWAL
    |--------------------------------------------------------------------------
    */
    Route::prefix('jadwal')
        ->middleware('permission:jadwal.view_umum|jadwal.view_sendiri')
        ->name('jadwal.')
        ->group(function () {

            Route::get('/', [JadwalController::class, 'index'])->name('index');
            Route::get('/pagi', [JadwalController::class, 'pagi'])->name('pagi');
            Route::get('/malam', [JadwalController::class, 'malam'])->name('malam');

            Route::middleware('permission:jadwal.manage')->group(function () {
                Route::get('/create', [JadwalController::class, 'create'])->name('create');
                Route::post('/', [JadwalController::class, 'store'])->name('store');
                Route::get('/{recno}', [JadwalController::class, 'show'])->name('show');
                Route::get('/{id}/edit', [JadwalController::class, 'edit'])->name('edit');
                Route::post('/{id}', [JadwalController::class, 'update'])->name('update');
                Route::delete('/{id}', [JadwalController::class, 'destroy'])->name('destroy');
            });
        });

    /*
    |--------------------------------------------------------------------------
    | PENAWARAN
    |--------------------------------------------------------------------------
    */
    Route::prefix('penawaran')
        ->middleware('permission:penawaran.manage')
        ->name('penawaran.')
        ->group(function () {

            Route::get('/', [PenawaranController::class, 'index'])->name('index');
            Route::get('/create', [PenawaranController::class, 'create'])->name('create');
            Route::post('/', [PenawaranController::class, 'store'])->name('store');
            Route::get('/{recno}', [PenawaranController::class, 'show'])->name('show');
            Route::put('/{penawaran}', [PenawaranController::class, 'update'])->name('update');
            Route::delete('/{recno}', [PenawaranController::class, 'destroy'])->name('destroy');
        });

    /*
    |--------------------------------------------------------------------------
    | PERWALIAN
    |--------------------------------------------------------------------------
    */
    Route::prefix('perwalian')
        ->middleware('permission:perwalian.manage')
        ->name('perwalian.')
        ->group(function () {

            Route::get('/', [PerwalianController::class, 'index'])->name('index');
            Route::get('/{mahasiswa}', [PerwalianController::class, 'show'])->name('show');
            Route::post('/{mahasiswa}/validasi')->name('validasi');
            Route::post('/{mahasiswa}/lock')->name('lock');
        });

    /*
    |--------------------------------------------------------------------------
    | MAHASISWA
    |--------------------------------------------------------------------------
    */
    Route::prefix('mahasiswa')
        ->name('mahasiswa.')
        ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | BIODATA MAHASISWA
        |--------------------------------------------------------------------------
        */
        Route::prefix('biodata')
            ->middleware('permission:biodata.view')
            ->name('biodata.')
            ->group(function () {

                Route::get('/', [BiodataMahasiswaController::class, 'index'])->name('index');
                // kalau nanti ada edit/update bisa ditambah:
                // Route::get('/edit', ...)->name('edit');
                // Route::patch('/', ...)->name('update');
            });

        /*
        |--------------------------------------------------------------------------
        | PENAWARAN
        |--------------------------------------------------------------------------
        */
        Route::prefix('penawaran')
            ->middleware('permission:penawaran.view')
            ->name('penawaran.')
            ->group(function () {

                Route::get('/', [PenawaranMahasiswaController::class, 'index'])->name('index');
            });

        /*
        |--------------------------------------------------------------------------
        | NILAI KRS
        |--------------------------------------------------------------------------
        */
        Route::prefix('nilai-krs')
            ->middleware('permission:nilai_krs.view')
            ->name('nilai_krs.')
            ->group(function () {

                Route::get('/', [NilaiKrsMahasiswaController::class, 'index'])->name('index');
            });

        /*
        |--------------------------------------------------------------------------
        | KHS
        |--------------------------------------------------------------------------
        */
        Route::prefix('khs')
            ->middleware('permission:khs.view')
            ->name('khs.')
            ->group(function () {
                Route::get('/', [NilaiKrsMahasiswaController::class, 'khs'])->name('index');
            });

        /*
        |--------------------------------------------------------------------------
        | KRS
        |--------------------------------------------------------------------------
        */
        Route::prefix('krs')
            ->name('krs.')
            ->group(function () {

                Route::get('/', [KrsMahasiswaController::class, 'index'])
                    ->middleware('permission:krs.view')
                    ->name('index');

                Route::post('/', [KrsMahasiswaController::class, 'store'])
                    ->middleware('permission:krs.submit')
                    ->name('store');

                Route::delete('/{id}', [KrsMahasiswaController::class, 'destroy'])
                    ->middleware('permission:krs.submit')
                    ->name('destroy');

                Route::delete('/batal-multiple', [KrsMahasiswaController::class, 'batalMultiple'])
                    ->middleware('permission:krs.submit')
                    ->name('batal_multiple');
            });

        

        /*
        |--------------------------------------------------------------------------
        | DETAIL MATA KULIAH
        |--------------------------------------------------------------------------
        */
        Route::get('/mata-kuliah/{kode_mk}', [DetailMataKuliahController::class, 'show'])
            ->name('mata_kuliah.show');
    });

    /*
    |--------------------------------------------------------------------------
    | INPUT NILAI
    |--------------------------------------------------------------------------
    */
    Route::prefix('input-nilai')
        ->middleware('permission:nilai.input')
        ->name('nilai.')
        ->group(function () {

            Route::get('/', [KrsController::class, 'list_matkul'])->name('index');
            Route::get('/{mk}/mahasiswa', [KrsController::class, 'list_mahasiswa'])->name('mahasiswa');
            Route::get('/{mahasiswa}/{mk}/create', [KrsController::class, 'create'])->name('create');
            Route::post('/{mahasiswa}/{mk}', [KrsController::class, 'store'])->name('store');
            Route::get('/{mahasiswa}/{mk}', [KrsController::class, 'show'])->name('show');
        });

    /*
    |--------------------------------------------------------------------------
    | PASSWORD
    |--------------------------------------------------------------------------
    */
    Route::get('/ubah-password', [UbahPasswordController::class, 'edit'])
        ->name('password.edit');

    Route::patch('/ubah-password/{user}', [UbahPasswordController::class, 'update'])
        ->name('password.update');
});

/*
|--------------------------------------------------------------------------
| GUEST
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {

    Route::get('/login', [LoginController::class, 'create'])
        ->name('login');

    Route::post('/login', [LoginController::class, 'store'])
        ->name('login.store');
});