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

        if (!$nrp) {
            return redirect()->back()->with('error', 'NRP tidak ditemukan.');
        }

        // Periode aktif (sesuaikan dengan kebutuhan)
        $periode = '2025/2026';

        $nilaiKrs = DB::table('krs')
            ->leftJoin('mk', 'krs.KODE', '=', 'mk.kodemk')
            ->where('krs.NRP', $nrp)
            ->where('krs.PERIODE', $periode)
            ->select(
                'krs.KODE',
                'mk.nama as nama_mk',
                'krs.SKS',
                'krs.BU',
                'krs.TTT1',
                'krs.TTT2',
                'krs.UTS',
                'krs.UAS',
                'krs.LAIN',
                'krs.NA'
            )
            ->orderBy('krs.KODE')
            ->get();

        return view('mahasiswa.nilai_krs.index', compact('nilaiKrs'));
    }
}