<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
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

        $data = DB::table('registrasi')
            ->leftJoin('penawaran', 'registrasi.penawaran_id', '=', 'penawaran.recno')
            ->leftJoin('semester', 'penawaran.semester_id', '=', 'semester.id')
            ->leftJoin('periode', 'semester.periode_id', '=', 'periode.id')
            ->leftJoin('mk', 'penawaran.kodemk', '=', 'mk.kodemk')
            ->leftJoin('krs', 'registrasi.regkrs', '=', 'krs.registrasi_id')
            ->where('registrasi.nrp', $mahasiswa->nrp)
            ->select(
                'periode.tahun_ajaran as periode',
                'semester.jenis as semester',
                'penawaran.kodemk as kode',
                'mk.nama as nama_mk',
                'mk.sks as sks',
                'krs.na'
            )
            ->orderBy('periode.tahun_ajaran')
            ->orderBy('semester.jenis')
            ->orderBy('penawaran.kodemk')
            ->get();

        $mahasiswaDetail = DB::table('mahasiswas')
            ->leftJoin('biodata', 'mahasiswas.nrp', '=', 'biodata.nrp')
            ->where('mahasiswas.nrp', $mahasiswa->nrp)
            ->select('mahasiswas.*', 'biodata.nama')
            ->first();

        $dosenWali = '-';
        if ($mahasiswa->dosen_wali) {
            $dosen = DB::table('dosen')
                ->where('nim_dosen', $mahasiswa->dosen_wali)
                ->first();

            $dosenWali = $dosen->nama ?? '-';
        }

        if ($data->isEmpty()) {
            return view('dosen_wali.nilai_khs_anak_wali.show', [
                'mahasiswa' => $mahasiswaDetail ?? $mahasiswa,
                'results' => collect(),
                'ipk' => 0,
                'total_sks_tempuh' => 0,
                'dosenWali' => $dosenWali,
                'periode_aktif' => '-',
                'semester_aktif' => '-',
            ]);
        }

        $grouped = $data->groupBy('periode');
        $results = [];
        $total_all_sks = 0;
        $total_all_mutu = 0;

        foreach ($grouped as $periode => $items) {
            $itemsWithMutu = $items->map(function ($item) {
                $item->mutu = $this->getBobot($item->na) * (float) ($item->sks ?? 0);
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

        $periode_aktif = $results[0]->periode ?? '-';
        $semester_aktif = $data->first()->semester ?? '-';

        return view('dosen_wali.nilai_khs_anak_wali.show', [
            'mahasiswa' => $mahasiswaDetail ?? $mahasiswa,
            'results' => $results,
            'ipk' => $ipk,
            'total_sks_tempuh' => $total_all_sks,
            'dosenWali' => $dosenWali,
            'periode_aktif' => $periode_aktif,
            'semester_aktif' => $semester_aktif,
        ]);
    }
}