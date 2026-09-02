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

        return $bobot[strtoupper($grade)] ?? 0.0;
    }

    public function index()
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;
        $nrp = $mahasiswa->nrp ?? $user->username ?? null;
        $statusBlokir = $mahasiswa->status_blokir;

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

        // Kontainer Utama Koleksi Transkrip
        $allTranskripData = collect();

        // 1. AMBIL DATA TRANSFER TERLEBIH DAHULU (Aman dengan leftJoin Query Builder)
        if ($mahasiswa->transfer == true || $mahasiswa->transfer == 1 || $mahasiswa->transfer == '1') {
            $transkripTransfer = DB::table('nilai_transfer')
                ->leftJoin('mk', 'nilai_transfer.kodemk', '=', 'mk.kodemk')
                ->where('nilai_transfer.nrp', $nrp)
                ->select(
                    'nilai_transfer.kodemk as kode',
                    'mk.nama as nama_mk',
                    'nilai_transfer.sks as sks', // Prioritaskan sks diakui di tabel transfer
                    'nilai_transfer.na',
                    DB::raw("'Asal SKS Pindahan' as jenis"),
                    DB::raw("'MATA KULIAH TRANSFER' as tahun_ajaran")
                )
                ->orderBy('nilai_transfer.kodemk')
                ->get();

            if ($transkripTransfer->isNotEmpty()) {
                $allTranskripData = $allTranskripData->concat($transkripTransfer);
            }
        }

        // 2. AMBIL DATA KRS REGULER
        $transkripReguler = DB::table('registrasi')
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

        // Sembunyikan nilai pada periode+semester yang sedang aktif jika bukan masa pengumuman
        if (!$pengumumanKrs) {
            $transkripReguler = $transkripReguler->filter(function ($item) use ($checkPeriode) {
                if (!$checkPeriode) {
                    return true;
                }
                $key = $item->tahun_ajaran . '|' . $item->jenis;
                return $key !== $checkPeriode;
            });
        }

        // Gabungkan data reguler di bawah data transfer menggunakan concat() agar indeks aman
        if ($transkripReguler->isNotEmpty()) {
            $allTranskripData = $allTranskripData->concat($transkripReguler);
        }

        // 3. HITUNG NILAI MUTU KUMULATIF GABUNGAN
        $transkripWithMutu = $allTranskripData->map(function ($item) {
            $item->mutu = $this->getBobot($item->na) * ($item->sks ?? 0);
            return $item;
        });

        $total_sks = $transkripWithMutu->sum('sks');
        $total_mutu = $transkripWithMutu->sum('mutu');
        $ipk = $total_sks > 0 ? $total_mutu / $total_sks : 0;

        $informasiUmum = [
            'periode' => $periodeAktif->tahun_ajaran ?? null,
            'program_studi' => $mahasiswa->programStudi->nama_prodi ?? null,
            'semester' => $semesterAktif ?? null,
            'nrp' => $mahasiswa->nrp ?? null,
            'nama' => $mahasiswa->biodata->nama ?? null,
            'dosen_wali' => $mahasiswa->dosen_wali ?? null,
            'semester_transfer' => $mahasiswa->transfer ? (int) $mahasiswa->semester_transfer : 0
        ];

        return view('mahasiswa.Transkrip_nilai.index', compact(
            'informasiUmum', 'transkripWithMutu', 'total_sks', 'total_mutu', 'ipk', 'statusBlokir', 'pengumumanKrs', 'pengumumanMulai', 'pengumumanSelesai'
        ));
    }
}
