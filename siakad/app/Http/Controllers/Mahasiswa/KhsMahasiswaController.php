<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KhsMahasiswaController extends Controller
{
    /**
     * Helper: Konversi Grade ke Bobot (Mutu)
     */
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

    /**
     * Helper: Tentukan SKS Maksimum Semester Berikutnya berdasarkan IPS
     */
    private function getMaxSks($ips)
    {
        if ($ips >= 3.00) return 24;
        if ($ips >= 2.50) return 21;
        if ($ips >= 2.00) return 18;
        if ($ips >= 1.50) return 16;
        if ($ips >= 1.00) return 12;
        return 9;
    }

    /**
     * Menampilkan KHS (Kartu Hasil Studi) per semester
     */
    public function index()
    {
        $user = Auth::user();
        $nrp = $user->nrp ?? $user->username ?? null;

        if (!$nrp) {
            return redirect()->back()->with('error', 'NRP tidak ditemukan.');
        }

        // Ambil data registrasi + nilai
        $data = DB::table('registrasi')
            ->leftJoin('krs', function ($join) {
                $join->on('registrasi.penawaran_id', '=', 'krs.kode')
                     ->on('registrasi.nrp', '=', 'krs.registrasi_id');
            })
            ->leftJoin('mk', 'registrasi.penawaran_id', '=', 'mk.kodemk')
            ->where('registrasi.nrp', $nrp)
            ->select(
                'registrasi.penawaran_id as kode',
                'mk.nama as nama_mk',
                'registrasi.sks as sks',
                'krs.na'
            )
            ->orderBy('registrasi.penawaran_id')
            ->get();

        if ($data->isEmpty()) {
            return view('mahasiswa.khs.index', [
                'results' => collect(),
                'ipk' => 0,
                'total_sks_tempuh' => 0,
                'mahasiswas' => null,
                'dosenWali' => '-',
                'periode_aktif' => '-',
                'semester_aktif' => '-'
            ]);
        }

        // Ambil data mahasiswa & dosen wali
        $mahasiswa = DB::table('mahasiswas')
            ->leftJoin('biodata', 'mahasiswas.nrp', '=', 'biodata.nrp')
            ->where('mahasiswas.nrp', $nrp)
            ->select('mahasiswas.*', 'biodata.nama', 'mahasiswas.prodi')
            ->first();

        $dosenWali = '-';
        if ($mahasiswa && $mahasiswa->dosen_wali) {
            $dosen = DB::table('dosen')->where('nim_dosen', $mahasiswa->dosen_wali)->first();
            $dosenWali = $dosen->nama ?? '-';
        }

        // Kelompokkan per periode dan hitung IPS / mutu
        $grouped = $data->groupBy('periode');
        $results = [];
        $total_all_sks = 0;
        $total_all_mutu = 0;

        foreach ($grouped as $periode => $items) {
            // Tambahkan mutu ke setiap item
            $itemsWithMutu = $items->map(function ($item) {
                $item->mutu = $this->getBobot($item->na) * ($item->sks ?? 0);
                return $item;
            });

            $total_sks = $itemsWithMutu->sum('sks');
            $total_mutu = $itemsWithMutu->sum('mutu');
            $ips = $total_sks > 0 ? $total_mutu / $total_sks : 0;

            $results[] = (object) [
                'periode'    => $periode,
                'items'      => $itemsWithMutu,
                'total_sks'  => $total_sks,
                'total_mutu' => $total_mutu,
                'ips'        => $ips,
                'max_sks'    => $this->getMaxSks($ips),
            ];

            $total_all_sks += $total_sks;
            $total_all_mutu += $total_mutu;
        }

        $ipk = $total_all_sks > 0 ? $total_all_mutu / $total_all_sks : 0;
        $total_sks_tempuh = $total_all_sks;

        // Data header
        $periode_aktif = $results[0]->periode ?? '-';
        $semester_aktif = 'GENAP'; // bisa diambil dari tabel setting

        return view('mahasiswa.khs.index', compact(
            'results',
            'ipk',
            'total_sks_tempuh',
            'mahasiswa',
            'dosenWali',
            'periode_aktif',
            'semester_aktif'
        ));
    }
}