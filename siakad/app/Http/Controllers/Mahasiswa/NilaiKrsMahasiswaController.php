<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Krs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Metaperiode;
use App\Models\Periode;
use App\Models\Semester;
use Illuminate\Database\Eloquent\Builder;

class NilaiKrsMahasiswaController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        
        $krsMahasiswa = Krs::whereHas('registrasi', function (Builder $query) use ($user) {
            $query->where('nrp', $user->mahasiswa->nrp);
        })->get();
        $datas = [];
        $periode = Periode::where('aktif','1')->first();
        $semester = $periode->whereHas('semesters', function (Builder $query) {
            $query->where('aktif', '1')->select('jenis');
        })->first();
        $metaperiode = Metaperiode::findOrFail(1);
    
        if (now()->between($metaperiode->pengumuman_nilai_final_mulai ?? now(), $metaperiode->pengumuman_nilai_final_selesai ?? now())) {
            return back()->withErrors(['error' => 'anda memasuki periode pengumuman nilai_final']);            
        }

        foreach($krsMahasiswa as $index => $krs) {
            $periode = $krs->registrasi->penawaran->semester->periode->tahun_ajaran;
            $semester = $krs->registrasi->penawaran->semester->jenis;
            $key = $periode . '|' . $semester;
            $datas[$key]['periode'] = $periode;
            $datas[$key]['semester'] = $semester;         
            $datas[$key]['items']['item'.$index+1] = [
                                'kode' => $krs->registrasi->penawaran->kodemk,
                                'mata_kuliah' => $krs->registrasi->penawaran->mk->nama,
                                'sks' => $krs->registrasi->penawaran->mk->sks,
                                'status' =>   $krs->bu,
                                'ttt1' =>   $krs->ttt1,
                                'ttt2' =>   $krs->ttt2,
                                'uts' =>    $krs->uts,
                                'uas' =>    $krs->uas,
                                'lain' =>   $krs->lain,
                                'grade' => $krs->na];     

        }
        $grouped = collect($datas)->map(function ($periode) {
            $periode['total_sks'] = collect($periode['items'])->sum('sks');
            return $periode;
        })->all();
        $informasiUmum = [
                            'periode' => $periode,
                            'program_studi' => $user->mahasiswa->programStudi->nama_prodi,
                            'semester' => $semester,
                            'nrp' => $user->mahasiswa->nrp,
                            'nama' => $user->mahasiswa->biodata->nama,
                            'dosen_wali' => $user->mahasiswa->dosen_wali
        ];      
        return view('mahasiswa.nilai_krs.index', compact('grouped', 'informasiUmum'));
    }
}