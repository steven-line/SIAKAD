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
        $periode = '2025';

        $nilaiKrs = DB::table('krs')
            ->leftJoin('mk', 'krs.kode', '=', 'mk.kodemk')
            ->where('krs.nrp', $nrp)
            ->where('krs.periode', $periode)
            ->select(
                'krs.kode',
                'mk.nama as nama_mk',
                'krs.sks',
                'krs.bu',
                'krs.ttt1',
                'krs.ttt2',
                'krs.uts',
                'krs.uas',
                'krs.lain',
                'krs.na'
            )
            ->orderBy('krs.kode')
            ->get();

        return view('mahasiswa.nilai_krs.index', compact('nilaiKrs'));
    }
}