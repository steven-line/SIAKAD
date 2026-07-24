<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Penawaran;
use App\Models\Registrasi;
use App\Models\Mahasiswa;
use App\Models\Metaperiode;
use Carbon\Carbon;
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
    
    $periodeKrs = Metaperiode::findOrFail(1);
    $statusBlokir = Auth::user()->mahasiswa->status_blokir;
  
    return view('mahasiswa.penawaran.show', compact('registrasis', 'penawaran', 'sudahAmbil', 'statusBlokir','periodeKrs'));
    }
    public function daftar(Penawaran $penawaran)
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;

        $periodeKrs = Metaperiode::findOrFail(1);
        if (!$mahasiswa) {
            return back()->with('error', 'Data mahasiswa tidak ditemukan.');
        }
        if (now()->lt($periodeKrs->krs_mulai) || now()->gt($periodeKrs->krs_selesai)) {
            return redirect()->back()->with('error', 'Pendaftaran gagal! Anda berada di luar periode KRS.');
        }
        // Hanya mahasiswa TERKUNCI yang tidak boleh mengambil KRS
        if ($mahasiswa->status_blokir === 'TERKUNCI') {
            return back()->with('error', 'KRS Anda terkunci. Tidak dapat mengambil mata kuliah.');
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
            'status' => 'B',
            'tanggal' => now()->toDateString(),
            'jam' => now()->toTimeString(),
        ]);

        return redirect()
            ->route('mahasiswa.krs.index')
            ->with('success', 'Berhasil mengambil KRS.');
    }

    public function batal(Penawaran $penawaran)
    {
        $mahasiswa = auth()->user()->mahasiswa;

        if (!$mahasiswa) {
            return back()->with('error', 'Data mahasiswa tidak ditemukan.');
        }

        if ($mahasiswa->status_blokir === 'TERKUNCI') {
            return back()->with('error', 'KRS Anda terkunci.');
        }

        Registrasi::where('nrp', $mahasiswa->nrp)
            ->where('penawaran_id', $penawaran->recno)
            ->delete();

        return back()->with('success', 'Berhasil membatalkan KRS.');
    }
}