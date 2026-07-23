<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Metaperiode;
use App\Models\Periode;

class KhsMahasiswaController extends Controller
{
    private function getBobot($grade)
    {
        return [
            'A'  => 4.0,
            'AB' => 3.5,
            'B'  => 3.0,
            'BC' => 2.5,
            'C'  => 2.0,
            'D'  => 1.0,
            'E'  => 0.0,
        ][$grade] ?? 0;
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

        $nrp = $user->mahasiswa->nrp;
        $statusBlokir = $user->mahasiswa->status_blokir;
            /*
    |--------------------------------------------------------------------------
    | Cek periode pengumuman nilai final
    |--------------------------------------------------------------------------
    */

    // Ambil periode yang sedang aktif
    $periodeAktif = Periode::where('aktif', 1)->first();

    // Ambil metaperiode sesuai periode aktif
    $metaperiode = null;

    if ($periodeAktif) {
        $metaperiode = Metaperiode::where('periode_id', $periodeAktif->id)->first();
    }

    // Jika sedang masa pengumuman nilai final,
    // mahasiswa tidak boleh melihat KHS
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

        $data = DB::table('registrasi')

            ->leftJoin('penawaran', 'registrasi.penawaran_id', '=', 'penawaran.recno')

            ->leftJoin('semester', 'penawaran.semester_id', '=', 'semester.id')

            ->leftJoin('periode', 'semester.periode_id', '=', 'periode.id')

            ->leftJoin('mk', 'penawaran.kodemk', '=', 'mk.kodemk')

            ->leftJoin('krs', 'registrasi.regkrs', '=', 'krs.registrasi_id')

            ->where('registrasi.nrp', $nrp)

            ->select(
                'periode.tahun_ajaran as periode',
                'semester.nama as semester',
                'penawaran.kodemk as kode',
                'mk.nama as nama_mk',
                'mk.sks',
                'krs.na'
            )

            ->orderBy('periode.tahun_ajaran')

            ->orderBy('penawaran.kodemk')

            ->get();

        $mahasiswa = DB::table('mahasiswas')

            ->leftJoin('biodata', 'mahasiswas.nrp', '=', 'biodata.nrp')

            ->where('mahasiswas.nrp', $nrp)

            ->select(
                'mahasiswas.*',
                'biodata.nama'
            )

            ->first();

        $dosenWali = '-';

        if ($mahasiswa && $mahasiswa->dosen_wali) {

            $dosen = DB::table('dosen')
                ->where('nim_dosen', $mahasiswa->dosen_wali)
                ->first();

            $dosenWali = $dosen->nama ?? '-';
        }

        if ($data->isEmpty()) {

            return view('mahasiswa.khs.index', [
                'results' => collect(),
                'ipk' => 0,
                'total_sks_tempuh' => 0,
                'mahasiswa' => $mahasiswa,
                'dosenWali' => $dosenWali,
                'periode_aktif' => '-',
                'semester_aktif' => '-',
                'statusBlokir' => $statusBlokir,
            ]);
        }

        $grouped = $data->groupBy('periode');

        $results = [];

        $total_all_sks = 0;

        $total_all_mutu = 0;

        foreach ($grouped as $periode => $items) {

            $items = $items->map(function ($item) {

                $item->mutu = $this->getBobot($item->na) * ($item->sks ?? 0);

                return $item;
            });

            $total_sks = $items->sum('sks');

            $total_mutu = $items->sum('mutu');

            $ips = $total_sks > 0
                ? $total_mutu / $total_sks
                : 0;

            $results[] = (object)[
                'periode' => $periode,
                'semester' => $items->first()->semester,
                'items' => $items,
                'total_sks' => $total_sks,
                'total_mutu' => $total_mutu,
                'ips' => $ips,
                'max_sks' => $this->getMaxSks($ips),
            ];

            $total_all_sks += $total_sks;

            $total_all_mutu += $total_mutu;
        }

        $ipk = $total_all_sks > 0
            ? $total_all_mutu / $total_all_sks
            : 0;

        $periode_aktif = $results[0]->periode ?? '-';

        $semester_aktif = $results[0]->semester ?? '-';

        $total_sks_tempuh = $total_all_sks;

        return view('mahasiswa.khs.index', compact(
            'results',
            'ipk',
            'total_sks_tempuh',
            'mahasiswa',
            'dosenWali',
            'periode_aktif',
            'semester_aktif',
            'statusBlokir'
        ));
    }
}