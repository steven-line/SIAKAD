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
        $krsMahasiswa = Registrasi::leftJoin('krs', 'registrasi.regkrs', '=', 'krs.registrasi_id')
                                   ->leftJoin('penawaran', 'registrasi.penawaran_id', '=', 'penawaran.recno')
                                   ->leftJoin('mk', 'penawaran.kodemk', '=', 'mk.kodemk')
                                   ->leftJoin('semester', 'penawaran.semester_id', '=', 'semester.id')
                                   ->leftJoin('periode', 'semester.periode_id', '=', 'periode.id')
                                   ->select('mk.kodemk as kode','mk.nama as mata_kuliah', 'krs.bu as status', 'krs.na as grade', 'krs.ttt1', 'krs.ttt2', 'krs.uts', 'krs.uas', 'krs.lain', 'mk.sks', 'periode.tahun_ajaran', 'semester.jenis')
                                   ->where('registrasi.nrp', $mahasiswa->nrp)
                                   ->get()
                                   ->groupBy(function($item) {
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
        $metaperiode = Metaperiode::findOrFail(1);
        $pengumumanKrs = null;
        if ($metaperiode && $metaperiode->pengumuman_nilai_final_mulai && $metaperiode->pengumuman_nilai_final_selesai && now()->between($metaperiode->pengumuman_nilai_final_mulai, $metaperiode->pengumuman_nilai_final_selesai)) {
               $pengumumanKrs = 'Anda memasuki periode pengumuman nilai final';         
        }
        $informasiUmum = [
                            'periode' => $periode->tahun_ajaran ?? null,
                            'program_studi' => $mahasiswa->programStudi->nama_prodi ?? null,
                            'semester' => $semester->jenis ?? null,
                            'nrp' => $mahasiswa->nrp ?? null,
                            'nama' => $mahasiswa->biodata->nama ?? null,
                            'dosen_wali' => $mahasiswa->dosen_wali ?? null
        ];      
        return view('dosen_wali.nilai_krs_anak_wali.show', compact('krsMahasiswa', 'informasiUmum', 'pengumumanKrs'));
    
}}

