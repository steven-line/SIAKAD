<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NilaiKrsMahasiswaController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $nrp = $user->nrp ?? $user->username ?? null;

        if (!$nrp) {
            return redirect()->back()->with('error', 'NRP tidak ditemukan.');
        }

        // Periode aktif (sesuaikan format dengan tabel registrasi)
        // Contoh: '2025/2026' atau '2025' – sesuaikan dengan data Anda
        $periode = '2025/2026'; // atau '2025' jika sesuai

        $nilaiKrs = DB::table('registrasi')
            ->leftJoin('krs', function ($join) use ($nrp, $periode) {
                $join->on('registrasi.kodemk', '=', 'krs.kode')
                     ->on('registrasi.nrp', '=', 'krs.nrp');
            })
            ->leftJoin('mk', 'registrasi.kodemk', '=', 'mk.kodemk')
            ->where('registrasi.nrp', $nrp)
            ->where('registrasi.periode', $periode)
            ->select(
                'registrasi.kodemk as kode',
                'mk.nama as nama_mk',
                'mk.sks as sks',
                'krs.bu',
                'krs.ttt1',
                'krs.ttt2',
                'krs.uts',
                'krs.uas',
                'krs.lain',
                'krs.na'
            )
            ->orderBy('registrasi.kodemk')
            ->get();

        return view('mahasiswa.nilai_krs.index', compact('nilaiKrs'));
    }


    /**
     * Menampilkan KHS (Kartu Hasil Studi) per semester
     */
    public function khs()
    {
        $user = Auth::user();
        $nrp = $user->nrp ?? $user->username ?? null;

        if (!$nrp) {
            return redirect()->back()->with('error', 'NRP tidak ditemukan.');
        }

        // Ambil semua data registrasi + nilai + mk
        $data = DB::table('registrasi')
            ->leftJoin('krs', function ($join) {
                $join->on('registrasi.kodemk', '=', 'krs.kode')
                     ->on('registrasi.nrp', '=', 'krs.nrp');
            })
            ->leftJoin('mk', 'registrasi.kodemk', '=', 'mk.kodemk')
            ->where('registrasi.nrp', $nrp)
            ->select(
                'registrasi.periode',
                'registrasi.kodemk as kode',
                'mk.nama as nama_mk',
                'mk.sks as sks',
                'krs.bu',
                'krs.na',
                'krs.uts',
                'krs.uas',
                'krs.ttt1',
                'krs.ttt2',
                'krs.lain'
            )
            ->orderBy('registrasi.periode')
            ->orderBy('registrasi.kodemk')
            ->get();

        // Kelompokkan berdasarkan periode (semester)
        $grouped = $data->groupBy('periode');

        return view('mahasiswa.khs.index', compact('grouped'));
    }

    /**
     * Menampilkan Transkrip Nilai (semua semester)
     */
    public function transkrip()
    {
        $user = Auth::user();
        $nrp = $user->nrp ?? $user->username ?? null;

        if (!$nrp) {
            return redirect()->back()->with('error', 'NRP tidak ditemukan.');
        }

        // Ambil semua data tanpa grouping
        $transkrip = DB::table('registrasi')
            ->leftJoin('krs', function ($join) {
                $join->on('registrasi.kodemk', '=', 'krs.kode')
                     ->on('registrasi.nrp', '=', 'krs.nrp');
            })
            ->leftJoin('mk', 'registrasi.kodemk', '=', 'mk.kodemk')
            ->where('registrasi.nrp', $nrp)
            ->select(
                'registrasi.periode',
                'registrasi.kodemk as kode',
                'mk.nama as nama_mk',
                'mk.sks as sks',
                'krs.bu',
                'krs.na',
                'krs.uts',
                'krs.uas',
                'krs.ttt1',
                'krs.ttt2',
                'krs.lain'
            )
            ->orderBy('registrasi.periode')
            ->orderBy('registrasi.kodemk')
            ->get();

        return view('mahasiswa.Transkrip_nilai.index', compact('transkrip'));
    }
}