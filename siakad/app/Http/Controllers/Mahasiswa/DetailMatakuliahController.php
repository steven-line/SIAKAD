<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Penawaran;
use App\Models\Registrasi;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DetailMataKuliahController extends Controller
{
    public function show(Penawaran $penawaran)
    {
        // ============================================================
        // 1. DAPATKAN PATAUM USER & SEMESTER AKTIF
    
    $registrasis = Registrasi::where('penawaran_id', $penawaran->recno)->get();
      $sudahAmbil = Registrasi::where('nrp', Auth::user()->mahasiswa->nrp)
    ->where('penawaran_id', $penawaran->recno)
    ->exists();
           
    return view('mahasiswa.penawaran.show', compact('registrasis', 'penawaran', 'sudahAmbil'));
    }
public function daftar(Penawaran $penawaran)
{
    $user = Auth::user();
    $mahasiswa = $user->mahasiswa;

    if (!$mahasiswa) {
        return back()->with('error', 'Data mahasiswa tidak ditemukan.');
    }

    // FIX INI
    $check = $mahasiswa->status_blokir === 'BELUM_KRS';

    if (!$check) {
        return back()->with('error', 'Tidak bisa mengambil KRS.');
    }

    $sudah = Registrasi::where('nrp', $mahasiswa->nrp)
        ->where('penawaran_id', $penawaran->recno)
        ->exists();

    if ($sudah) {
        return back()->with('error', 'Sudah mengambil mata kuliah ini.');
    }

    Registrasi::create([
        'nrp' => $mahasiswa->nrp,
        'penawaran_id' => $penawaran->recno,
        'status' => 'BARU',
        'tanggal' => now()->toDateString(),
        'jam' => now()->toTimeString(),
    ]);
   
    return back()->with('success', 'Berhasil mengambil KRS.');
}


    public function batal(Penawaran $penawaran)
    {
        $mahasiswa = auth()->user()->mahasiswa;

        if (!$mahasiswa) {
            return back()->with('error', 'Data mahasiswa tidak ditemukan.');
        }

        Registrasi::where('nrp', $mahasiswa->nrp)
            ->where('penawaran_id', $penawaran->recno)
            ->delete();

        return back()->with('success', 'Berhasil membatalkan KRS.');
    }
}