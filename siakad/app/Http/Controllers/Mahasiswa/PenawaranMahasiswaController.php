<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Krs;
use App\Models\Penawaran;
use App\Models\Registrasi;
use Illuminate\Support\Facades\Auth;

class PenawaranMahasiswaController extends Controller
{
    public function index()
    {
        // Ambil pataum dari session
        $pataum = session('pataum');
        $statusBlokir = Auth::user()->mahasiswa->status_blokir;

        // Jika tidak ada di session, ambil dari user (fallback)
        if (!$pataum) {
            $user = Auth::user();
            if ($user && isset($user->pataum)) {
                $pataum = substr($user->pataum, 0, 1);
            }
        }

        $prodi = Auth::user()?->mahasiswa?->prodi;
        $nrp   = Auth::user()?->username;
        $pataumMahasiswa = Auth::user()->pataum;

        // Query penawaran dengan filter prodi & semester aktif
        $query = Penawaran::with([
                'mk.kurikulum',
                'semester',
                'dosenRelasi'
            ])
            ->whereHas('semester', function ($q) {
                $q->where('aktif', 1);
            })
            ->whereHas('mk.kurikulum', function ($q) use ($prodi) {
                $q->where('kode_prodi', $prodi);
            })->where('pataum', $pataumMahasiswa);

        $penawaran = $query->get();

        // Cek prasyarat setiap mata kuliah
        foreach ($penawaran as $item) {
            $this->cekPrasyarat($item, $nrp);
        }

        return view('mahasiswa.penawaran.index', compact(
            'penawaran',
            'statusBlokir'
        ));
    }

    /**
     * Detail penawaran mata kuliah
     */
    public function show(Penawaran $penawaran)
    {
        $statusBlokir = Auth::user()->mahasiswa->status_blokir;
        $nrp = Auth::user()->username;

        $penawaran->load([
            'mk.kurikulum',
            'semester',
            'dosenRelasi',
            'registrasi.mahasiswa.biodata'
        ]);

        // Gunakan logika yang sama dengan index()
        $this->cekPrasyarat($penawaran, $nrp);

        $registrasis = $penawaran->registrasi;

        $sudahAmbil = $registrasis
            ->where('nrp', $nrp)
            ->isNotEmpty();

        return view('mahasiswa.penawaran.show', compact(
            'penawaran',
            'registrasis',
            'statusBlokir',
            'sudahAmbil'
        ));
    }

    /**
     * Mengecek apakah mahasiswa memenuhi prasyarat mata kuliah.
     */
    private function cekPrasyarat(Penawaran $penawaran, string $nrp): void
    {
        $penawaran->boleh_diambil = true;
        $penawaran->pesan_prasyarat = '';

        $mk = $penawaran->mk;

        if (!$mk) {
            return;
        }

        $prasyarat = [];

        for ($i = 1; $i <= 10; $i++) {

            $prasyarat = [];

            for ($i = 1; $i <= 10; $i++) {

                $kode = trim((string) ($mk->{'prasyarat'.$i} ?? ''));

                if (
                    $kode === '' ||
                    $kode === '-' ||
                    strtoupper($kode) === 'NULL'
                ) {
                    continue;
                }

                $prasyarat[] = $kode;
            }
        }

        foreach ($prasyarat as $kodeMk) {

            if (empty($prasyarat)) {
                return;
            }
            
            $registrasi = Registrasi::where('nrp', $nrp)
                ->whereHas('penawaran', function ($q) use ($kodeMk) {
                    $q->where('kodemk', $kodeMk);
                })
                ->first();

            if (!$registrasi) {

                $penawaran->boleh_diambil = false;
                $penawaran->pesan_prasyarat =
                    'Belum mengambil mata kuliah prasyarat '.$kodeMk;

                return;
            }

            $lulus = Krs::where('registrasi_id', $registrasi->regkrs)
                ->whereIn('na', ['A','AB','B','BC','C'])
                ->exists();

            if (!$lulus) {

                $penawaran->boleh_diambil = false;
                $penawaran->pesan_prasyarat =
                    'Belum lulus mata kuliah prasyarat '.$kodeMk;

                return;
            }

            if (!$lulus) {

                $penawaran->boleh_diambil = false;
                $penawaran->pesan_prasyarat = 'Belum memenuhi prasyarat mata kuliah.';

                return;
            }
        }
    }
}