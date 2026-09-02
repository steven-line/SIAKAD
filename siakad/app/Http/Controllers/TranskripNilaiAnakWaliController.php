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

        return $bobot[strtoupper($grade)] ?? 0.0;
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
        
        $pengumumanKrs = null;
        if ($metaperiode && $metaperiode->pengumuman_nilai_final_mulai && $metaperiode->pengumuman_nilai_final_selesai && now()->between($metaperiode->pengumuman_nilai_final_mulai, $metaperiode->pengumuman_nilai_final_selesai)) {
               $pengumumanKrs = 'Anda memasuki periode pengumuman nilai final';         
        }
    
        if (!$nrp) {
            return redirect()->back()->with('error', 'NRP tidak ditemukan.');
        }

        // Ambil semester aktif saat ini
        $semesterAktif = $periodeAktif?->semesters()->where('aktif', 1)->pluck('jenis')->first();

        // Kontainer Utama Koleksi Transkrip Anak Wali
        $allTranskripData = collect();

        // 1. AMBIL DATA TRANSFER TERLEBIH DAHULU (Urutan Teratas Lembar Transkrip)
        if ($mahasiswa->transfer == true || $mahasiswa->transfer == 1 || $mahasiswa->transfer == '1') {
            $transkripTransfer = DB::table('nilai_transfer')
                ->leftJoin('mk', 'nilai_transfer.kodemk', '=', 'mk.kodemk')
                ->where('nilai_transfer.nrp', $nrp)
                ->select(
                    'nilai_transfer.kodemk as kode',
                    'mk.nama as nama_mk',
                    'nilai_transfer.sks as sks',
                    'nilai_transfer.na',
                    DB::raw("'Asal SKS Pindahan' as jenis"),
                    DB::raw("'MATA KULIAH TRANSFER' as tahun_ajaran")
                )
                ->orderBy('nilai_transfer.kodemk')
                ->get();

            if ($transkripTransfer->isNotEmpty()) {
                $allTranskripData = $allTranskripData->concat($transkripTransfer);
            }
        }

        // 2. AMBIL DATA KRS REGULER
        $transkripReguler = DB::table('registrasi')
            ->leftJoin('penawaran', 'registrasi.penawaran_id', '=', 'penawaran.recno')
            ->leftJoin('semester', 'penawaran.semester_id', '=', 'semester.id')
            ->leftJoin('periode', 'semester.periode_id', '=', 'periode.id')
            ->leftJoin('mk', 'penawaran.kodemk', '=', 'mk.kodemk')
            ->leftJoin('krs', function ($join) {
                $join->on('registrasi.regkrs', '=', 'krs.registrasi_id');
            })
            ->where('registrasi.nrp', $nrp)
            ->whereNotNull('krs.na')
            ->where('krs.na', '!=', '')
            ->select(
                'penawaran.kodemk as kode',
                'mk.nama as nama_mk',
                'mk.sks as sks',
                'krs.na',
                'semester.jenis',
                'periode.tahun_ajaran'
            )
            ->orderBy('periode.tahun_ajaran')
            ->orderBy('semester.jenis')
            ->orderBy('penawaran.kodemk')
            ->get();

        // Gabungkan data reguler di bawah data transfer menggunakan concat()
        if ($transkripReguler->isNotEmpty()) {
            $allTranskripData = $allTranskripData->concat($transkripReguler);
        }

        // 3. HITUNG NILAI MUTU KUMULATIF GABUNGAN
        $transkripWithMutu = $allTranskripData->map(function ($item) {
            $item->mutu = $this->getBobot($item->na) * ($item->sks ?? 0);
            return $item;
        });
    
        $total_sks = $transkripWithMutu->sum('sks');
        $total_mutu = $transkripWithMutu->sum('mutu');
        $ipk = $total_sks > 0 ? $total_mutu / $total_sks : 0;

        // Memperbaiki pemanggilan variabel profil yang sebelumnya salah ($periode & $semester tidak terdefinisi)
        $informasiUmum = [
            'periode' => $periodeAktif->tahun_ajaran ?? null,
            'program_studi' => $mahasiswa->programStudi->nama_prodi ?? null,
            'semester' => $semesterAktif ?? null,
            'nrp' => $mahasiswa->nrp,
            'nama' => $mahasiswa->biodata->nama ?? null,
            'dosen_wali' => $mahasiswa->dosen_wali,
            'semester_transfer' => $mahasiswa->transfer ? (int) $mahasiswa->semester_transfer : 0
        ]; 

        return view('dosen_wali.transkrip_nilai_anak_wali.show', compact('transkripWithMutu', 'total_sks', 'total_mutu', 'ipk', 'statusBlokir', 'pengumumanKrs', 'informasiUmum'));
    }
}
