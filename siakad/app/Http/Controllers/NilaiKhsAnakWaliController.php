<?php

namespace App\Http\Controllers;

use App\Models\Krs;
use App\Models\Mahasiswa;
use App\Models\Metaperiode;
use App\Models\Periode;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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

        return $bobot[strtoupper($grade)] ?? 0.0;
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

        $datas = [];

        // 1. AMBIL & PROSES DATA TRANSFER TERLEBIH DAHULU (Aman dengan DB::table & leftJoin)
        if ($mahasiswa->transfer == true || $mahasiswa->transfer == 1 || $mahasiswa->transfer == '1') {
            $nilaiTransfer = DB::table('nilai_transfer')
                ->leftJoin('mk', 'nilai_transfer.kodemk', '=', 'mk.kodemk')
                ->where('nilai_transfer.nrp', $mahasiswa->nrp)
                ->select('nilai_transfer.kodemk', 'mk.nama', 'nilai_transfer.sks', 'nilai_transfer.na')
                ->get();
            
            if ($nilaiTransfer->isNotEmpty()) {
                $keyTransfer = 'MATA KULIAH TRANSFER|Asal SKS Pindahan';
                $datas[$keyTransfer] = [
                    'periode' => 'MATA KULIAH TRANSFER',
                    'semester' => 'Asal SKS Pindahan',
                    'is_transfer' => true,
                    'items' => []
                ];

                foreach ($nilaiTransfer as $tIndex => $tf) {
                    $sks = $tf->sks ?? 0;
                    $datas[$keyTransfer]['items']['tf_' . $tIndex] = [
                        'kode' => $tf->kodemk,
                        'mata_kuliah' => $tf->nama ?? 'N/A',
                        'sks' => $sks,
                        'grade' => $tf->na,
                        'mutu' => $sks * $this->getBobot($tf->na)
                    ];
                }
            }
        }

        // 2. AMBIL & PROSES DATA KRS REGULER
        $krsMahasiswa = Krs::whereHas('registrasi', function (Builder $query) use ($mahasiswa) {
            $query->where('nrp', $mahasiswa->nrp);
        })->with(['registrasi.penawaran.semester.periode', 'registrasi.penawaran.mk'])->get();

        $periodeAktif = Periode::where('aktif', 1)->first();
        $jenisSemester = $periodeAktif->semesters()->where('aktif', 1)->pluck('jenis')->first();
        $checkPeriode = $periodeAktif->tahun_ajaran . '|' . $jenisSemester;

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
        if ($metaperiode && $metaperiode->pengumuman_nilai_final_mulai && $metaperiode->pengumuman_nilai_final_selesai && now()->between($metaperiode->pengumuman_nilai_final_mulai, $metaperiode->pengumuman_nilai_final_selesai)) {
               $pengumumanKrs = 'Anda memasuki periode pengumuman nilai final';         
        }

        foreach($krsMahasiswa as $index => $krs) {
            $penawaran = $krs->registrasi->penawaran ?? null;
            if (!$penawaran) continue;

            $periode = $penawaran->semester->periode->tahun_ajaran;
            $semester = $penawaran->semester->jenis;
            $key = $periode . '|' . $semester;

            if($key != $checkPeriode || $pengumumanKrs) {
                if (!isset($datas[$key])) {
                    $datas[$key] = [
                        'periode' => $periode,
                        'semester' => $semester,
                        'is_transfer' => false,
                        'items' => []
                    ];
                }

                $sks = $penawaran->mk->sks ?? 0;
                $datas[$key]['items']['item_'.$index] = [
                    'kode' => $penawaran->kodemk,
                    'mata_kuliah' => $penawaran->mk->nama ?? 'N/A',
                    'sks' => $sks,
                    'grade' => $krs->na,
                    'mutu' => $sks * $this->getBobot($krs->na)
                ];    
            }
        }

        // 3. KALKULASI IPS PER SEMESTER & TOTAL AKUMULASI UNTUK IPK
        $totalMutuIpk = 0;
        $totalSksIpk = 0;

        $grouped = collect($datas)->map(function ($value) use (&$totalMutuIpk, &$totalSksIpk) {
            $value['total_mutu'] = collect($value['items'])->sum('mutu');
            $value['total_sks'] = collect($value['items'])->sum('sks');
            
            if ($value['total_sks'] > 0) {
                $value['ips'] = $value['total_mutu'] / $value['total_sks'];
            } else {
                $value['ips'] = 0.00;
            }

            $totalMutuIpk += $value['total_mutu'];
            $totalSksIpk += $value['total_sks'];

            return $value;
        })->all();

        // Penghitungan IPK Baku Institusi Nasional
        $ipk = $totalSksIpk > 0 ? ($totalMutuIpk / $totalSksIpk) : 0.00;
        
        $informasiUmum = [
            'periode' => $periodeAktif->tahun_ajaran ?? null,
            'program_studi' => $mahasiswa->programStudi->nama_prodi ?? null,
            'semester' => $jenisSemester ?? null,
            'nrp' => $mahasiswa->nrp,
            'nama' => $mahasiswa->biodata->nama ?? null,
            'dosen_wali' => $mahasiswa->dosen_wali,
            'semester_transfer' => $mahasiswa->transfer ? (int) $mahasiswa->semester_transfer : 0
        ];     

        return view('dosen_wali.nilai_khs_anak_wali.show', compact('grouped', 'informasiUmum', 'ipk', 'pengumumanKrs', 'periodeKosong'));
    }
}
