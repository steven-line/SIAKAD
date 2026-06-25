<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NilaiKrsMahasiswaController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $nrp = $user->nrp ?? $user->username ?? null;
        $statusBlokir = $user->mahasiswa->status_blokir;
        if (!$nrp) {
            return redirect()->back()->with('error', 'NRP tidak ditemukan.');
        }

        // Periode aktif (sesuaikan dengan data Anda)
        $periode = '2025/2026'; // atau ambil dari session / setting

        $nilaiKrs = DB::table('registrasi')
            ->leftJoin('penawaran', 'registrasi.penawaran_id', '=', 'penawaran.recno')
            ->leftJoin('mk', 'penawaran.kodemk', '=', 'mk.kodemk')
            ->leftJoin('krs', function ($join) {
                $join->on('registrasi.regkrs', '=', 'krs.registrasi_id')
                     ->on('penawaran.kodemk', '=', 'krs.kode');
            })
            ->where('registrasi.nrp', $nrp)
            ->select(
                'penawaran.kodemk as kode',
                'mk.nama as nama_mk',
                'mk.sks as sks',
                'registrasi.status',
                'krs.ttt1',
                'krs.ttt2',
                'krs.uts',
                'krs.uas',
                'krs.lain',
                'krs.na'
            )
            ->orderBy('penawaran.kodemk')
            ->get();

        return view('mahasiswa.nilai_krs.index', compact('nilaiKrs', 'statusBlokir'));
    }
}