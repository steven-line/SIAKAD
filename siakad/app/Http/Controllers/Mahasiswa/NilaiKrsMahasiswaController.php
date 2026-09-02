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
use App\Models\NilaiTransfer; 
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class NilaiKrsMahasiswaController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;

        // Wadah utama penampung data (Koleksi Kosong bawaan Laravel)
        $allKrsData = collect();

        // 1. Ambil data nilai transfer terlebih dahulu agar posisinya mutlak di paling atas
        if ($mahasiswa->transfer == true || $mahasiswa->transfer == 1 || $mahasiswa->transfer == '1') {
            $krsTransfer = NilaiTransfer::leftJoin('mk', 'nilai_transfer.kodemk', '=', 'mk.kodemk')
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
                                   DB::raw("'MATA KULIAH TRANSFER' as tahun_ajaran"), 
                                   DB::raw("'Asal SKS Pindahan' as jenis")
                               )
                               ->where('nilai_transfer.nrp', $mahasiswa->nrp)
                               ->get();

            if ($krsTransfer->isNotEmpty()) {
                // SOLUSI MUTLAK: Menggunakan concat() agar indeks array tidak ditimpa
                $allKrsData = $allKrsData->concat($krsTransfer);
            }
        }

        // 2. Ambil data nilai KRS Reguler
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
            // Gabungkan di bawah baris data transfer dengan aman
            $allKrsData = $allKrsData->concat($krsReguler);
        }

        // 3. Proses Grouping (Blok transfer dikunci aman di baris urutan pertama)
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
        if (
            $metaperiode &&
            $metaperiode->pengumuman_nilai_final_mulai &&
            $metaperiode->pengumuman_nilai_final_selesai &&
            now()->between($metaperiode->pengumuman_nilai_final_mulai, $metaperiode->pengumuman_nilai_final_selesai)
        ) {
            $pengumumanKrs = 'Anda memasuki periode pengumuman nilai final';
        }

        // Mengirimkan variabel nilai semester_transfer asli milik mahasiswa ke Blade
        $informasiUmum = [
                            'periode' => $periode->tahun_ajaran ?? null,
                            'program_studi' => $mahasiswa->programStudi->nama_prodi ?? null,
                            'semester' => $semester->jenis ?? null,
                            'nrp' => $mahasiswa->nrp ?? null,
                            'nama' => $mahasiswa->biodata->nama ?? null,
                            'dosen_wali' => $mahasiswa->dosen_wali ?? null,
                            'semester_transfer' => $mahasiswa->transfer ? (int) $mahasiswa->semester_transfer : 0
        ];      
        return view('mahasiswa.nilai_krs.index', compact('krsMahasiswa', 'informasiUmum', 'pengumumanKrs', 'periodeKosong'));
    }
}
