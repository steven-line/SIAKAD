<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TranskripMahasiswaController extends Controller
{
    /**
     * Helper: Konversi Grade ke Bobot (Mutu)
     */
    private function getBobot($grade)
    {
        $bobot = [
            'A'  => 4.0,
            'AB' => 3.5,
            'B'  => 3.0,
            'BC' => 2.5,
            'C'  => 2.0,
            'D'  => 1.0,
            'E'  => 0.0,
        ];
        return $bobot[$grade] ?? 0.0;
    }

    /**
     * Menampilkan Transkrip Nilai (semua semester)
     */
    public function index()
    {
        $user = Auth::user();
        $nrp = $user->nrp ?? $user->username ?? null;

        if (!$nrp) {
            return redirect()->back()->with('error', 'NRP tidak ditemukan.');
        }

        $transkrip = DB::table('registrasi')
            ->leftJoin('krs', function ($join) {
                $join->on('registrasi.penawaran_id', '=', 'krs.kode')
                     ->on('registrasi.nrp', '=', 'krs.registrasi_id');
            })
            ->leftJoin('mk', 'registrasi.penawaran_id', '=', 'mk.kodemk')
            ->where('registrasi.nrp', $nrp)
            ->select(
                'registrasi.penawaran_id',
                'mk.nama as nama_mk',
                'registrasi.sks as sks',
                'krs.na'
            )
            ->orderBy('registrasi.penawaran_id')
            ->get();

        // Tambahkan mutu ke setiap item
        $transkripWithMutu = $transkrip->map(function ($item) {
            $item->mutu = $this->getBobot($item->na) * ($item->sks ?? 0);
            return $item;
        });

        $total_sks = $transkripWithMutu->sum('sks');
        $total_mutu = $transkripWithMutu->sum('mutu');
        $ipk = $total_sks > 0 ? $total_mutu / $total_sks : 0;

        return view('mahasiswa.Transkrip_nilai.index', compact('transkripWithMutu', 'total_sks', 'total_mutu', 'ipk'));
    }
}