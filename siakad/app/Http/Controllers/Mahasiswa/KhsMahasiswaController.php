<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $user = Auth::user();
        $nrp = $user->nrp ?? $user->username ?? null;

        if (!$nrp) {
            return redirect()->back()->with('error', 'NRP tidak ditemukan.');
        }

        // (Opsional) filter periode jika diperlukan
        // $periode = '2025/2026';

        $data = DB::table('registrasi')
            // 1. JOIN ke penawaran untuk mendapatkan kodemk & info lainnya
            ->leftJoin('penawaran', 'registrasi.penawaran_id', '=', 'penawaran.recno')
            // 2. JOIN ke mk untuk nama mata kuliah
            ->leftJoin('mk', 'penawaran.kodemk', '=', 'mk.kodemk')
            // 3. JOIN ke krs untuk nilai (jika ada)
            ->leftJoin('krs', function ($join) {
                $join->on('registrasi.nrp', '=', 'krs.registrasi_id')
                     ->on('penawaran.kodemk', '=', 'krs.kode');
            })
            ->where('registrasi.nrp', $nrp)
            // ->where('registrasi.periode', $periode) // aktifkan jika perlu
            ->select(
                'penawaran.kodemk as kode',
                'mk.nama as nama_mk',
                'registrasi.sks as sks',
                'krs.na'
            )
            ->orderBy('penawaran.kodemk')
            ->get();

        if ($data->isEmpty()) {
            return view('mahasiswa.khs.index', [
                'results' => collect(),
                'ipk' => 0,
                'total_sks_tempuh' => 0,
                'mahasiswa' => null,
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

        $periode_aktif = $results[0]->periode ?? '-';
        $semester_aktif = 'GENAP';

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