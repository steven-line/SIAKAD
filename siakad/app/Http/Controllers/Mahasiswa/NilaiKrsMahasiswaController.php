<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Krs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Metaperiode;
use App\Models\Periode;
use App\Models\Registrasi;
use App\Models\Semester;
use Illuminate\Database\Eloquent\Builder;

class NilaiKrsMahasiswaController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $krsMahasiswa = Registrasi::leftJoin('krs', 'registrasi.regkrs', '=', 'krs.registrasi_id')
                                   ->leftJoin('penawaran', 'registrasi.penawaran_id', '=', 'penawaran.recno')
                                   ->leftJoin('mk', 'penawaran.kodemk', '=', 'mk.kodemk')
                                   ->leftJoin('semester', 'penawaran.semester_id', '=', 'semester.id')
                                   ->leftJoin('periode', 'semester.periode_id', '=', 'periode.id')
                                   ->select('mk.kodemk as kode','mk.nama as mata_kuliah', 'krs.sks', 'krs.bu as status', 'krs.na as grade', 'krs.ttt1', 'krs.ttt2', 'krs.uts', 'krs.uas', 'krs.lain', 'mk.sks', 'periode.tahun_ajaran', 'semester.jenis')
                                   ->where('registrasi.nrp', $user->mahasiswa->nrp)
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
        if (now()->between($metaperiode->pengumuman_nilai_final_mulai ?? now(), $metaperiode->pengumuman_nilai_final_selesai ?? now())) {
            return back()->withErrors(['error' => 'anda memasuki periode pengumuman nilai_final']);            
        }
        $informasiUmum = [
                            'periode' => $periode->tahun_ajaran ?? null,
                            'program_studi' => $user->mahasiswa->programStudi->nama_prodi ?? null,
                            'semester' => $semester->jenis ?? null,
                            'nrp' => $user->mahasiswa->nrp ?? null,
                            'nama' => $user->mahasiswa->biodata->nama ?? null,
                            'dosen_wali' => $user->mahasiswa->dosen_wali ?? null
        ];      
        return view('mahasiswa.nilai_krs.index', compact('krsMahasiswa', 'informasiUmum'));
    }
}