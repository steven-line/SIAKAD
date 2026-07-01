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
        $nrp = $user->mahasiswa->nrp ?? null;
        $statusBlokir = $user->mahasiswa->status_blokir;
        if (!$nrp) {
            return redirect()->back()->with('error', 'NRP tidak ditemukan.');
        }


        $nilaiKrs = DB::table('registrasi')
        ->join('penawaran', 'registrasi.penawaran_id', '=', 'penawaran.recno')
        ->join('mk', 'penawaran.kodemk', '=', 'mk.kodemk')
        ->leftJoin('krs', 'registrasi.regkrs', '=', 'krs.registrasi_id')
        ->where('registrasi.nrp', $nrp)
        ->select(
            'registrasi.regkrs',
            'penawaran.kodemk as kode',
            'mk.nama as nama_mk',
            'mk.sks as sks',
            'registrasi.status',
            'krs.ttt1',
            'krs.ttt2',
            'krs.ttt3',
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