<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\Metaperiode;
use App\Models\Periode;
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

        
        $nrp = $mahasiswa->nrp;
        $statusBlokir = $mahasiswa->status_blokir;

            /*
    |--------------------------------------------------------------------------
    | Cek periode pengumuman nilai final
    |--------------------------------------------------------------------------
    */

    // Ambil periode yang sedang aktif
    $periodeAktif = Periode::where('aktif', 1)->first();

    // Ambil metaperiode sesuai periode aktif
    $metaperiode = null;

    if ($periodeAktif) {
        $metaperiode = Metaperiode::where('periode_id', $periodeAktif->id)->first();
    }
    
    // Jika sedang masa pengumuman nilai final,
    // mahasiswa tidak boleh melihat transkrip nilai

    $pengumumanKrs = null;
        if ($metaperiode && $metaperiode->pengumuman_nilai_final_mulai && $metaperiode->pengumuman_nilai_final_selesai && now()->between($metaperiode->pengumuman_nilai_final_mulai, $metaperiode->pengumuman_nilai_final_selesai)) {
               $pengumumanKrs = 'Anda memasuki periode pengumuman nilai final';         
        }
    
        if (!$nrp) {
            return redirect()->back()->with('error', 'NRP tidak ditemukan.');
        }

        $transkrip = DB::table('registrasi')
            ->leftJoin('penawaran', 'registrasi.penawaran_id', '=', 'penawaran.recno')
            ->leftJoin('mk', 'penawaran.kodemk', '=', 'mk.kodemk')
            ->leftjoin('krs', function ($join) {
                $join->on('registrasi.regkrs', '=', 'krs.registrasi_id');
                  
            })
            ->where('registrasi.nrp', $nrp)
            ->whereNotNull('krs.na')
            ->where('krs.na', '!=', '')
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

        $informasiUmum = [
                            'periode' => $periode->tahun_ajaran ?? null,
                            'program_studi' => $mahasiswa->programStudi->nama_prodi ?? null,
                            'semester' => $semester->jenis ?? null,
                            'nrp' => $mahasiswa->nrp ?? null,
                            'nama' => $mahasiswa->biodata->nama ?? null,
                            'dosen_wali' => $mahasiswa->dosen_wali ?? null
        ]; 

        return view('dosen_wali.transkrip_nilai_anak_wali.show', compact('transkripWithMutu', 'total_sks', 'total_mutu', 'ipk', 'statusBlokir', 'pengumumanKrs', 'informasiUmum'));
    }

}
