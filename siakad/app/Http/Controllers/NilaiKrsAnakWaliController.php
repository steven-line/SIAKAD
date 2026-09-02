<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\Metaperiode;
use App\Models\Periode;
use App\Models\Registrasi;
use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class NilaiKrsAnakWaliController extends Controller
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

        return view('dosen_wali.nilai_krs_anak_wali.index', [
            'mahasiswas' => $mahasiswas,
        ]);
    }

    public function show(Mahasiswa $mahasiswa)
    {
        $nimDosen = auth()->user()->dosen->nim_dosen;

        // Pastikan mahasiswa adalah anak wali dosen yang login
        if ($mahasiswa->dosen_wali !== $nimDosen) {
            abort(403);
        }

        // Wadah utama penampung data (Koleksi Kosong bawaan Laravel)
        $allKrsData = collect();

        // 1. AMBIL DATA TRANSFER TERLEBIH DAHULU (Menggunakan Query Builder agar posisi di paling atas)
        if ($mahasiswa->transfer == true || $mahasiswa->transfer == 1 || $mahasiswa->transfer == '1') {
            $krsTransfer = DB::table('nilai_transfer')
                               ->leftJoin('mk', 'nilai_transfer.kodemk', '=', 'mk.kodemk')
                               ->select(
                                   'nilai_transfer.kodemk as kode',
                                   'mk.nama as mata_kuliah',
                                   DB::raw("'Transfer' as status"),
                                   'nilai_transfer.na as grade',
                                   DB::raw('NULL as ttt1'),
                                   DB::raw('NULL as ttt2'),
                                   DB::raw('NULL as uts'),
                                   DB::raw('NULL as uas'),
                                   DB::raw('NULL as lain'),
                                   'nilai_transfer.sks',
                                   DB::raw("'MATA KULIAH TRANSFER' as tahun_ajaran"), // Label pemisah kelompok
                                   DB::raw("'Asal SKS Pindahan' as jenis")
                               )
                               ->where('nilai_transfer.nrp', $mahasiswa->nrp)
                               ->get();

            if ($krsTransfer->isNotEmpty()) {
                $allKrsData = $allKrsData->concat($krsTransfer);
            }
        }

        // 2. AMBIL DATA KRS REGULER
        $krsReguler = Registrasi::leftJoin('krs', 'registrasi.regkrs', '=', 'krs.registrasi_id')
                                   ->leftJoin('penawaran', 'registrasi.penawaran_id', '=', 'penawaran.recno')
                                   ->leftJoin('mk', 'penawaran.kodemk', '=', 'mk.kodemk')
                                   ->leftJoin('semester', 'penawaran.semester_id', '=', 'semester.id')
                                   ->leftJoin('periode', 'semester.periode_id', '=', 'periode.id')
                                   ->select(
                                       'mk.kodemk as kode',
                                       'mk.nama as mata_kuliah', 
                                       'krs.bu as status', 
                                       'krs.na as grade', 
                                       'krs.ttt1', 
                                       'krs.ttt2', 
                                       'krs.uts', 
                                       'krs.uas', 
                                       'krs.lain', 
                                       'mk.sks', 
                                       'periode.tahun_ajaran', 
                                       'semester.jenis'
                                   )
                                   ->where('registrasi.nrp', $mahasiswa->nrp)
                                   ->get();

        if ($krsReguler->isNotEmpty()) {
            $allKrsData = $allKrsData->concat($krsReguler);
        }

        // 3. PROSES GROUPING
        $krsMahasiswa = $allKrsData->groupBy(function($item) {
                                    return $item->tahun_ajaran . '|' . $item->jenis;
                                  })->map(function($group) {
                                    return [
                                        'periode' => $group->first()->tahun_ajaran,
                                        'semester' => $group->first()->jenis,
                                        'total_sks' => $group->sum('sks'),
                                        'matkul' => $group
                                    ];
                                  });
    
        $periode = Periode::where('aktif','1')->first();
        $semester = Semester::join('periode', function($join){
           $join->on('semester.periode_id', '=', 'periode.id')
                ->where('periode.aktif', '=', '1'); 
        })->select('jenis')->where('semester.aktif', '1')->first();       
        
        try {
            $metaperiode = Metaperiode::findOrFail(1);
        } catch (ModelNotFoundException $e) {
            $metaperiode = null;
        }

        $periodeKosong = null;
        if (!$metaperiode) {
            $periodeKosong = 'Anda belum memasuki periode yang aktif';
        }

        $pengumumanKrs = null;
        if ($metaperiode && $metaperiode->pengumuman_nilai_final_mulai && $metaperiode->pengumuman_nilai_final_selesai && now()->between($metaperiode->pengumuman_nilai_final_mulai, $metaperiode->pengumuman_nilai_final_selesai)) {
               $pengumumanKrs = 'Anda memasuki periode pengumuman nilai final';         
        }

        // Menyisipkan kolom semester_transfer agar dibaca oleh logika penambahan indeks di View Blade Dosen Wali
        $informasiUmum = [
                            'periode' => $periode->tahun_ajaran ?? null,
                            'program_studi' => $mahasiswa->programStudi->nama_prodi ?? null,
                            'semester' => $semester->jenis ?? null,
                            'nrp' => $mahasiswa->nrp ?? null,
                            'nama' => $mahasiswa->biodata->nama ?? null,
                            'dosen_wali' => $mahasiswa->dosen_wali ?? null,
                            'semester_transfer' => $mahasiswa->transfer ? (int) $mahasiswa->semester_transfer : 0
        ];      

        return view('dosen_wali.nilai_krs_anak_wali.show', compact('krsMahasiswa', 'informasiUmum', 'pengumumanKrs', 'periodeKosong'));
    }
}
