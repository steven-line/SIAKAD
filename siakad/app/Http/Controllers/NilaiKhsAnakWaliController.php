<?php

namespace App\Http\Controllers;

use App\Models\Krs;
use App\Models\Mahasiswa;
use App\Models\Metaperiode;
use App\Models\Periode;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NilaiKhsAnakWaliController extends Controller
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
        $nimDosen = auth()->user()->dosen->nim_dosen;

        $mahasiswas = Mahasiswa::where('dosen_wali', $nimDosen)
            ->orderBy('nrp')
            ->paginate(15);

        return view('dosen_wali.nilai_khs_anak_wali.index', [
            'mahasiswas' => $mahasiswas,
        ]);
    }

    public function show(Mahasiswa $mahasiswa)
    {
        $nimDosen = Auth::user()->dosen->nim_dosen ?? null;

        if (!$nimDosen) {
            abort(403, 'Akun dosen tidak valid.');
        }

        if ($mahasiswa->dosen_wali !== $nimDosen) {
            abort(403);
        }

        {
        $nimDosen = Auth::user()->dosen->nim_dosen ?? null;        
        
        $krsMahasiswa = Krs::whereHas('registrasi', function (Builder $query) use ($mahasiswa) {
            $query->where('nrp', $mahasiswa->nrp);
            
        })->get();
        $datas = [];
        $ips = 0;
        $periode = Periode::where('aktif','1')->first();
        $semester = $periode->leftJoin('semester', 'periode.id', '=',  'semester.periode_id')
                            ->where('semester.aktif', '1')
                            ->select('semester.jenis')
                            ->first();

        $metaperiode = Metaperiode::findOrFail(1);
        $periodeAktif = Periode::where('aktif', 1)->first();
        $jenisSemester = $periodeAktif->semesters()->where('aktif', 1)->pluck('jenis')->first();
        $checkPeriode = $periodeAktif->tahun_ajaran . '|' . $jenisSemester;

      
        $pengumumanKrs = null;
        if ($metaperiode && $metaperiode->pengumuman_nilai_final_mulai && $metaperiode->pengumuman_nilai_final_selesai && now()->between($metaperiode->pengumuman_nilai_final_mulai, $metaperiode->pengumuman_nilai_final_selesai)) {
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
                            'program_studi' => $mahasiswa->programStudi->nama_prodi,
                            'semester' => $jenisSemester ?? null,
                            'nrp' => $mahasiswa->nrp,
                            'nama' => $mahasiswa->biodata->nama ?? null,
                            'dosen_wali' => $mahasiswa->dosen_wali
        ];     

        return view('dosen_wali.nilai_khs_anak_wali.show', compact('grouped', 'informasiUmum', 'ipk', 'pengumumanKrs'));
    
    }
    }
}