<?php

namespace App\Http\Controllers;

use App\Models\Metaperiode;
use App\Models\Periode;
use App\Models\Ips;
use App\Models\Krs;
use App\Models\Mahasiswa;
use App\Models\Mk;
use Illuminate\Http\Request;

class MetaperiodeController extends Controller
{
    /**
     * Halaman Master Setting Periode.
     */
    public function index()
    {
        /*
         * ==========================================================
         * PERIODE AKTIF
         * ==========================================================
         */
        $periode = Periode::with([
            'semesters' => function ($q) {
                $q->where('aktif', 1);
            }
        ])
        ->where('aktif', 1)
        ->first();


        /*
         * ==========================================================
         * META PERIODE
         * ==========================================================
         */
        $metaperiode = null;

        if ($periode) {
            $metaperiode = Metaperiode::where(
                'periode_id',
                $periode->id
            )->first();
        }


        /*
         * ==========================================================
         * MATA KULIAH KHUSUS
         * ==========================================================
         *
         * HANYA MK dengan:
         *
         * mk.jenis = "khusus"
         *
         * yang ditampilkan di Master Setting.
         */
        $mkKhusus = Mk::where('aktif', 1)
            ->where('jenis', 'khusus')
            ->orderBy('nama')
            ->get();


        /*
         * ==========================================================
         * MK KHUSUS YANG TOGGLE-NYA AKTIF
         * ==========================================================
         *
         * metaperiode.mk_khusus menyimpan ARRAY KODE MK.
         *
         * Contoh:
         *
         * [
         *     "AA26A702",
         *     "AA26A703"
         * ]
         */
        $mkKhususAktif = $metaperiode?->mk_khusus ?? [];


        /*
         * Pastikan selalu berupa array.
         */
        if (!is_array($mkKhususAktif)) {
            $mkKhususAktif = [];
        }


        /*
         * ==========================================================
         * NORMALISASI KODE MK
         * ==========================================================
         *
         * Supaya perbandingan dengan value checkbox
         * konsisten.
         */
        $mkKhususAktif = collect($mkKhususAktif)
            ->map(function ($kodemk) {
                return trim((string) $kodemk);
            })
            ->filter()
            ->unique()
            ->values()
            ->toArray();


        /*
         * ==========================================================
         * VIEW
         * ==========================================================
         */
        return view(
            'admin.metaperiode.index',
            compact(
                'metaperiode',
                'periode',
                'mkKhusus',
                'mkKhususAktif'
            )
        );
    }


    /**
     * Simpan Master Setting Periode.
     */
    public function update(Request $request)
    {
        /*
         * ==========================================================
         * VALIDASI
         * ==========================================================
         */
        $validated = $request->validate([

            /*
             * ======================================================
             * PERIODE
             * ======================================================
             */
            'periode_id' => [
                'required',
                'exists:periode,id'
            ],


            /*
             * ======================================================
             * INPUT PENAWARAN
             * ======================================================
             */
            'input_penawaran_mulai' => [
                'nullable',
                'date'
            ],

            'input_penawaran_selesai' => [
                'nullable',
                'date',
                'after:input_penawaran_mulai'
            ],


            /*
             * ======================================================
             * KRS
             * ======================================================
             */
            'krs_mulai' => [
                'required',
                'date'
            ],

            'krs_selesai' => [
                'required',
                'date',
                'after:krs_mulai'
            ],


            /*
             * ======================================================
             * INPUT NILAI UTS UMUM
             * ======================================================
             *
             * Periode ini berlaku untuk MK NORMAL.
             */
            'input_nilai_uts_mulai' => [
                'nullable',
                'date'
            ],

            'input_nilai_uts_selesai' => [
                'nullable',
                'date',
                'after:input_nilai_uts_mulai'
            ],


            /*
             * ======================================================
             * INPUT NILAI UAS UMUM
             * ======================================================
             *
             * Periode ini berlaku untuk MK NORMAL.
             */
            'input_nilai_uas_mulai' => [
                'nullable',
                'date'
            ],

            'input_nilai_uas_selesai' => [
                'nullable',
                'date',
                'after:input_nilai_uas_mulai'
            ],


            /*
             * ======================================================
             * MK KHUSUS
             * ======================================================
             *
             * Yang dikirim dari Blade adalah KODE MK.
             *
             * Contoh:
             *
             * mk_khusus[] = AA26A702
             * mk_khusus[] = AA26A703
             *
             * Hanya MK yang jenis-nya "khusus" yang boleh
             * masuk ke array ini.
             */
            'mk_khusus' => [
                'nullable',
                'array'
            ],

            'mk_khusus.*' => [
                'string',
                'exists:mk,kodemk'
            ],


            /*
             * ======================================================
             * PENGUMUMAN NILAI FINAL
             * ======================================================
             */
            'pengumuman_nilai_final_mulai' => [
                'nullable',
                'date'
            ],

            'pengumuman_nilai_final_selesai' => [
                'nullable',
                'date',
                'after:pengumuman_nilai_final_mulai'
            ],
        ]);


        /*
         * ==========================================================
         * NORMALISASI MK KHUSUS
         * ==========================================================
         */
        $mkKhususAktif = collect(
            $validated['mk_khusus'] ?? []
        )
        ->map(function ($kodemk) {
            return trim((string) $kodemk);
        })
        ->filter()
        ->unique()
        ->values()
        ->toArray();


        /*
         * ==========================================================
         * PENTING:
         * PASTIKAN HANYA MK dengan jenis = "khusus"
         * YANG BOLEH DISIMPAN.
         * ==========================================================
         */
        if (!empty($mkKhususAktif)) {

            $mkKhususAktif = Mk::whereIn(
                'kodemk',
                $mkKhususAktif
            )
            ->where('jenis', 'khusus')
            ->pluck('kodemk')
            ->map(function ($kodemk) {
                return trim((string) $kodemk);
            })
            ->values()
            ->toArray();
        }


        /*
         * Masukkan array MK khusus ke data yang akan disimpan.
         */
        $validated['mk_khusus'] = $mkKhususAktif;


        /*
         * ==========================================================
         * CARI META PERIODE
         * ==========================================================
         */
        $data = Metaperiode::where(
            'periode_id',
            $validated['periode_id']
        )->first();


        /*
         * ==========================================================
         * SIMPAN / UPDATE
         * ==========================================================
         */
        if ($data) {

            $data->update($validated);

        } else {

            Metaperiode::create($validated);
        }


        /*
         * ==========================================================
         * GENERATE IPS
         * ==========================================================
         */
        $this->generateIpsIfAllowed();


        /*
         * ==========================================================
         * REDIRECT
         * ==========================================================
         */
        return back()->with(
            'success',
            'Pengaturan periode berhasil disimpan.'
        );
    }


    /**
     * Generate IPS setelah pengumuman nilai final selesai.
     */
    private function generateIpsIfAllowed()
    {
        /*
         * Ambil MetaPeriode.
         */
        $meta = Metaperiode::first();


        /*
         * Jika belum melewati periode pengumuman,
         * jangan generate IPS.
         */
        if (
            !$meta ||
            !$meta->pengumuman_nilai_final_selesai ||
            now()->lte($meta->pengumuman_nilai_final_selesai)
        ) {
            return;
        }


        /*
         * Ambil seluruh mahasiswa.
         */
        $mahasiswas = Mahasiswa::all();


        foreach ($mahasiswas as $mahasiswa) {

            /*
             * Ambil KRS mahasiswa.
             */
            $krs = Krs::with('registrasi')
                ->whereHas('registrasi', function ($q) use ($mahasiswa) {
                    $q->where('nrp', $mahasiswa->nrp);
                })
                ->get();


            $totalSks = 0;
            $totalMutu = 0;


            foreach ($krs as $item) {

                $bobot = $this->getBobot($item->na);

                $totalMutu += $bobot * $item->sks;

                $totalSks += $item->sks;
            }


            /*
             * Hitung IPS.
             */
            $ips = 0;

            if ($totalSks > 0) {
                $ips = round(
                    $totalMutu / $totalSks,
                    3
                );
            }


            /*
             * Tentukan maksimal SKS.
             */
            $maksimalSks = $ips >= 3.000
                ? 24
                : 21;


            /*
             * Simpan / update IPS.
             */
            Ips::updateOrCreate(
                [
                    'nrp' => $mahasiswa->nrp,
                ],
                [
                    'ips' => $ips,
                    'maksimal_sks' => $maksimalSks,
                ]
            );
        }
    }


    /**
     * Konversi nilai menjadi bobot.
     */
    private function getBobot($nilai)
    {
        return match ($nilai) {

            'A'  => 4.00,
            'AB' => 3.50,
            'B'  => 3.00,
            'BC' => 2.50,
            'C'  => 2.00,
            'D'  => 1.00,

            default => 0.00,
        };
    }
}
