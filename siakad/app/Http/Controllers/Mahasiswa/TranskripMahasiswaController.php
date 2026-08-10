<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Metaperiode;
use App\Models\Periode;

class TranskripMahasiswaController extends Controller
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

    public function index()
    {
        $user = Auth::user();
        $nrp = $user->nrp ?? $user->username ?? null;
        $statusBlokir = $user->mahasiswa->status_blokir;

        /*
        |--------------------------------------------------------------------------
        | Cek periode pengumuman nilai final
        |--------------------------------------------------------------------------
        */

        $periodeAktif = Periode::where('aktif', 1)->first();

        $metaperiode = null;
        if ($periodeAktif) {
            $metaperiode = Metaperiode::where('periode_id', $periodeAktif->id)->first();
        }

        $pengumumanKrs = null;
        $pengumumanMulai = null;
        $pengumumanSelesai = null;

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
            $pengumumanMulai = $metaperiode->pengumuman_nilai_final_mulai;
            $pengumumanSelesai = $metaperiode->pengumuman_nilai_final_selesai;
        }

        if (!$nrp) {
            return redirect()->back()->with('error', 'NRP tidak ditemukan.');
        }

        // Ambil semester aktif saat ini
        $semesterAktif = $periodeAktif?->semesters()->where('aktif', 1)->pluck('jenis')->first();
 
        // Pembanding seperti di KHS: periode_ajaran + jenis semester aktif
        $checkPeriode = ($periodeAktif && $semesterAktif)
            ? $periodeAktif->tahun_ajaran . '|' . $semesterAktif
            : null;

        $transkrip = DB::table('registrasi')
            ->leftJoin('penawaran', 'registrasi.penawaran_id', '=', 'penawaran.recno')
            ->leftJoin('semester', 'penawaran.semester_id', '=', 'semester.id')
            ->leftJoin('periode', 'semester.periode_id', '=', 'periode.id')
            ->leftJoin('mk', 'penawaran.kodemk', '=', 'mk.kodemk')
            ->leftJoin('krs', function ($join) {
                $join->on('registrasi.regkrs', '=', 'krs.registrasi_id');
            })
            ->where('registrasi.nrp', $nrp)
            ->whereNotNull('krs.na')
            ->where('krs.na', '!=', '')
            ->select(
                'penawaran.kodemk as kode',
                'mk.nama as nama_mk',
                'mk.sks as sks',
                'krs.na',
                'semester.jenis',
                'periode.tahun_ajaran'
            )
            ->orderBy('periode.tahun_ajaran')
            ->orderBy('semester.jenis')
            ->orderBy('penawaran.kodemk')
            ->get();

        // Sembunyikan nilai pada periode+semester yang sedang aktif
        $transkrip = $transkrip->filter(function ($item) use ($checkPeriode) {
            if (!$checkPeriode) {
                return true;
            }

            $key = $item->tahun_ajaran . '|' . $item->jenis;
            return $key !== $checkPeriode;
        })->values();

        $transkripWithMutu = $transkrip->map(function ($item) {
            $item->mutu = $this->getBobot($item->na) * ($item->sks ?? 0);
            return $item;
        });

        $total_sks = $transkripWithMutu->sum('sks');
        $total_mutu = $transkripWithMutu->sum('mutu');
        $ipk = $total_sks > 0 ? $total_mutu / $total_sks : 0;

        $informasiUmum = [
                            'periode' => $periodeAktif->tahun_ajaran ?? null,
                            'program_studi' => $user->mahasiswa->programStudi->nama_prodi ?? null,
                            'semester' => $semesterAktif ?? null,
                            'nrp' => $user->mahasiswa->nrp ?? null,
                            'nama' => $user->mahasiswa->biodata->nama ?? null,
                            'dosen_wali' => $user->mahasiswa->dosen_wali ?? null
        ];

        return view('mahasiswa.Transkrip_nilai.index', compact('informasiUmum', 'transkripWithMutu', 'total_sks', 'total_mutu', 'ipk', 'statusBlokir', 'pengumumanKrs', 'pengumumanMulai', 'pengumumanSelesai'
        ));
    }
}