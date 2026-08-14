<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Krs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Metaperiode;
use App\Models\Periode;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class KhsMahasiswaController extends Controller
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

    private function getMaxSks($ips)
    {
        if ($ips >= 3.00) return 24;
        if ($ips >= 2.50) return 21;
        if ($ips >= 2.00) return 18;
        if ($ips >= 1.50) return 16;
        if ($ips >= 1.00) return 12;
        return 9;
    }



    public function index()
    {
        $nimDosen = Auth::user()->dosen->nim_dosen ?? null;        
        $user = Auth::user();
        $krsMahasiswa = Krs::whereHas('registrasi', function (Builder $query) use ($user) {
            $query->where('nrp', $user->mahasiswa->nrp);
            
        })->get();
        $datas = [];
        $ips = 0;
        $periode = Periode::where('aktif','1')->first();
        $semester = $periode->leftJoin('semester', 'periode.id', '=',  'semester.periode_id')
                            ->where('semester.aktif', '1')
                            ->select('semester.jenis')
                            ->first();

        try {
            $metaperiode = Metaperiode::findOrFail(1);
        } catch (ModelNotFoundException $e) {
            $metaperiode = null;
        }

        $periodeKosong = null;

        if (!$metaperiode) {
            $periodeKosong = 'Anda belum memasuki periode yang aktif';
        }

        $periodeAktif = Periode::where('aktif', 1)->first();
        $jenisSemester = $periodeAktif->semesters()->where('aktif', 1)->pluck('jenis')->first();
        $checkPeriode = $periodeAktif->tahun_ajaran . '|' . $jenisSemester;


        // Tetap menggunakan algoritma pengumumanKrs
        $pengumumanKrs = null;

        if (
            $metaperiode &&
            $metaperiode->pengumuman_nilai_final_mulai &&
            $metaperiode->pengumuman_nilai_final_selesai &&
            now()->between(
                $metaperiode->pengumuman_nilai_final_mulai,
                $metaperiode->pengumuman_nilai_final_selesai
            )
        ) {
            $pengumumanKrs = 'Anda memasuki periode pengumuman nilai final';         
        }
        
        foreach($krsMahasiswa as $index => $krs) {
            $periode = $krs->registrasi->penawaran->semester->periode->tahun_ajaran;
            $semester = $krs->registrasi->penawaran->semester->jenis;

            $key = $periode . '|' . $semester;
            if($key != $checkPeriode) {
                  $datas[$key]['periode'] = $periode;
                  $datas[$key]['semester'] = $semester;
                  $datas[$key]['items']['item'.$index+1] = [
                                        'kode' => $krs->registrasi->penawaran->kodemk,
                                        'mata_kuliah' => $krs->registrasi->penawaran->mk->nama,
                                        'sks' => $krs->registrasi->penawaran->mk->sks,
                                        'grade' => $krs->na,
                                        'mutu' => $krs->registrasi->penawaran->mk->sks * $this->getBobot($krs->na)];    
            }
           
                                


        }
        $grouped = collect($datas)->map(function ($periode) {
            $periode['total_mutu'] = collect($periode['items'])->sum('mutu');
            $periode['total_sks'] = collect($periode['items'])->sum('sks');
            $periode['ips'] = $periode['total_mutu'] / $periode['total_sks']; 

            return $periode;
        })->all();

        if (count($grouped) == 0) {
            $ipk = 0;
        } else {
            $ipk = array_sum(array_column($grouped, 'ips'))/(count($grouped));
               
        }
        
        $informasiUmum = [
                            'periode' => $periodeAktif->tahun_ajaran ?? null,
                            'program_studi' => $user->mahasiswa->programStudi->nama_prodi,
                            'semester' => $jenisSemester ?? null,
                            'nrp' => $user->mahasiswa->nrp,
                            'nama' => $user->mahasiswa->biodata->nama ?? null,
                            'dosen_wali' => $user->mahasiswa->dosen_wali
        ];     

        return view('mahasiswa.KHS.index', compact('grouped', 'informasiUmum', 'ipk', 'pengumumanKrs', 'periodeKosong'));
    
    }
}