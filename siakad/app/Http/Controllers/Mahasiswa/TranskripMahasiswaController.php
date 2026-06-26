<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TranskripMahasiswaController extends Controller
{
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

    public function index()
    {
        $user = Auth::user();
        $nrp = $user->nrp ?? $user->username ?? null;
        $statusBlokir = $user->mahasiswa->status_blokir;
        if (!$nrp) {
            return redirect()->back()->with('error', 'NRP tidak ditemukan.');
        }

        $transkrip = DB::table('registrasi')
            ->leftJoin('penawaran', 'registrasi.penawaran_id', '=', 'penawaran.recno')
            ->leftJoin('mk', 'penawaran.kodemk', '=', 'mk.kodemk')
            ->leftJoin('krs', function ($join) {
                $join->on('registrasi.regkrs', '=', 'krs.registrasi_id')
                     ->on('penawaran.kodemk', '=', 'krs.registrasi_id');
            })
            ->where('registrasi.nrp', $nrp)
            ->select(
                'penawaran.kodemk as kode',
                'mk.nama as nama_mk',
                'mk.sks as sks',
                'krs.na'
            )
            ->orderBy('penawaran.kodemk')
            ->get();

        $transkripWithMutu = $transkrip->map(function ($item) {
            $item->mutu = $this->getBobot($item->na) * ($item->sks ?? 0);
            return $item;
        });

        $total_sks = $transkripWithMutu->sum('sks');
        $total_mutu = $transkripWithMutu->sum('mutu');
        $ipk = $total_sks > 0 ? $total_mutu / $total_sks : 0;

        return view('mahasiswa.Transkrip_nilai.index', compact('transkripWithMutu', 'total_sks', 'total_mutu', 'ipk', 'statusBlokir'));
    }
}