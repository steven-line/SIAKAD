<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TranskripNilaiAnakWaliController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
        {
            $nimDosen = auth()->user()->dosen->nim_dosen;

            $mahasiswas = Mahasiswa::where('dosen_wali', $nimDosen)
                ->orderBy('nrp')
                ->paginate(15);

            return view('dosen_wali.transkrip_nilai_anak_wali.index', [
                'mahasiswas' => $mahasiswas,
            ]);

        }

    
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

    public function show(Mahasiswa $mahasiswa)
    {
        $nimDosen = auth()->user()->dosen->nim_dosen;

        if ($mahasiswa->dosen_wali !== $nimDosen) {
            abort(403);
        }

        $transkrip = DB::table('registrasi')
            ->join('penawaran', 'registrasi.penawaran_id', '=', 'penawaran.recno')
            ->join('mk', 'penawaran.kodemk', '=', 'mk.kodemk')
            ->leftJoin('krs', 'registrasi.regkrs', '=', 'krs.registrasi_id')
            ->where('registrasi.nrp', $mahasiswa->nrp)
            ->select(
                'mk.kodemk as kode',
                'mk.nama as nama_mk',
                'mk.sks',
                'krs.na'
            )
            ->orderBy('mk.kodemk')
            ->get();

        $transkripWithMutu = $transkrip->map(function ($item) {
            $item->mutu = $this->getBobot($item->na) * ($item->sks ?? 0);
            return $item;
        });

        $total_sks = $transkripWithMutu->sum('sks');
        $total_mutu = $transkripWithMutu->sum('mutu');
        $ipk = $total_sks > 0 ? $total_mutu / $total_sks : 0;

        $biodata = DB::table('biodata')
            ->where('nrp', $mahasiswa->nrp)
            ->first();

        $dosenWali = DB::table('dosen')
            ->where('nim_dosen', $mahasiswa->dosen_wali)
            ->value('nama');

        return view('dosen_wali.transkrip_nilai_anak_wali.show', [
            'mahasiswa'          => $mahasiswa,
            'biodata'            => $biodata,
            'dosenWali'          => $dosenWali,
            'transkripWithMutu'  => $transkripWithMutu,
            'total_sks'          => $total_sks,
            'total_mutu'         => $total_mutu,
            'ipk'                => $ipk,
        ]);
    }

}
