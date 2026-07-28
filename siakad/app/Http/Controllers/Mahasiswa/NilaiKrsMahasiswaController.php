<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Metaperiode;
use App\Models\Periode;

class NilaiKrsMahasiswaController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $nrp = $user->mahasiswa->nrp ?? null;
        $statusBlokir = $user->mahasiswa->status_blokir;

        if (!$nrp) {
            return redirect()->back()->with('error', 'NRP tidak ditemukan.');
        }

        /*
        |--------------------------------------------------------------------------
        | Cek periode pengumuman nilai final
        |--------------------------------------------------------------------------
        */

        // Ambil periode yang sedang aktif
        $periodeAktif = Periode::where('aktif', 1)->first();
        $semesterAktif = $periodeAktif ? $periodeAktif->semesters()->where('aktif', 1)->first() : null;
        // Ambil tahun masuk mahasiswa
        $tahunMasuk = $user->mahasiswa->tahun_masuk ?? null;

        // Default semester
        $semesterKe = null;

        if ($tahunMasuk && $semesterAktif && $periodeAktif) {
            // Ambil tahun dari periode (contoh: 2023/2024 → 2023)
            $tahunPeriode = (int) substr($periodeAktif->tahun_ajaran, 0, 4);

            // Hitung selisih tahun
            $selisihTahun = $tahunPeriode - $tahunMasuk;

            // Hitung semester dasar
            $semesterKe = $selisihTahun * 2;

            // Tambahkan berdasarkan jenis semester
            if ($semesterAktif->jenis === 'Ganjil') {
                $semesterKe += 1;
            } elseif ($semesterAktif->jenis === 'Genap') {
                $semesterKe += 2;
            }
        }
        // Ambil metaperiode sesuai periode aktif
        $metaperiode = null;

        if ($periodeAktif) {
            $metaperiode = Metaperiode::where('periode_id', $periodeAktif->id)->first();
        }

        // Jika sedang masa pengumuman nilai final,
        // mahasiswa tidak boleh melihat nilai KRS
        if (
            $metaperiode &&
            $metaperiode->pengumuman_nilai_final_mulai &&
            $metaperiode->pengumuman_nilai_final_selesai &&
            now()->between(
                $metaperiode->pengumuman_nilai_final_mulai,
                $metaperiode->pengumuman_nilai_final_selesai
            )
        ) {
        return view('mahasiswa.nilai_krs.index', [
            'nilaiKrs' => collect(),
            'statusBlokir' => $statusBlokir,
            'periodePengumuman' => true,
            'pengumumanSelesai' => $metaperiode->pengumuman_nilai_final_selesai,
        ]);
        }

        $nilaiKrs = DB::table('registrasi')
        ->join('penawaran', 'registrasi.penawaran_id', '=', 'penawaran.recno')
        ->join('semester', 'penawaran.semester_id', '=', 'semester.id')
        ->join('periode', 'semester.periode_id', '=', 'periode.id')
        ->join('mk', 'penawaran.kodemk', '=', 'mk.kodemk')
        ->leftJoin('krs', 'registrasi.regkrs', '=', 'krs.registrasi_id')
        ->where('registrasi.nrp', $nrp)
        ->select(
            'registrasi.regkrs',
            'penawaran.kodemk as kode',
            'mk.nama as nama_mk',
            'mk.sks as sks',
            'registrasi.status',
            'krs.ttt1',
            'krs.ttt2',
            'krs.ttt3',
            'krs.uts',
            'krs.uas',
            'krs.lain',
            'krs.na',
            
            'semester.jenis',
            'semester.id as semester_id',
            'periode.tahun_ajaran'
        )
        ->orderBy('periode.tahun_ajaran')
        ->orderBy('semester.id')
        ->orderBy('penawaran.kodemk')
        ->get();
        $mahasiswa = Auth::user()->mahasiswa->tahun_masuk ?? null;
        $nilaiKrsGrouped = $nilaiKrs->groupBy(function ($item) {
            return $item->tahun_ajaran . ' - ' . $item->jenis;
        });

        return view('mahasiswa.nilai_krs.index', compact('mahasiswa','nilaiKrsGrouped', 'statusBlokir', 'periodeAktif', 'semesterAktif', 'semesterKe'));
    }
}