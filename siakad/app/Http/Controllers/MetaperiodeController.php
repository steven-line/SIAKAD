<?php

namespace App\Http\Controllers;

use App\Models\Metaperiode;
use App\Models\Periode;
use App\Models\Ips;
use App\Models\Krs;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class MetaperiodeController extends Controller
{
    public function index()
    {
        $periode = Periode::with([
            'semesters' => function ($q) {
                $q->where('aktif', 1);
            }
        ])->where('aktif', 1)->first();

        $metaperiode = null;

        if ($periode) {
            $metaperiode = Metaperiode::where('periode_id', $periode->id)->first();
        }

        return view('admin.metaperiode.index', compact('metaperiode', 'periode'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'periode_id' => 'required|exists:periode,id',

            /*
            |--------------------------------------------------------------------------
            | Periode Input Penawaran
            |--------------------------------------------------------------------------
            */
            'input_penawaran_mulai' => 'nullable|date',
            'input_penawaran_selesai' => 'nullable|date|after:input_penawaran_mulai',

            /*
            |--------------------------------------------------------------------------
            | Periode KRS
            |--------------------------------------------------------------------------
            */
            'krs_mulai' => 'required|date',
            'krs_selesai' => 'required|date|after:krs_mulai',

            /*
            |--------------------------------------------------------------------------
            | Periode Input Nilai UTS
            |--------------------------------------------------------------------------
            */
            'input_nilai_uts_mulai' => 'nullable|date',
            'input_nilai_uts_selesai' => 'nullable|date|after:input_nilai_uts_mulai',

            /*
            |--------------------------------------------------------------------------
            | Periode Input Nilai UAS
            |--------------------------------------------------------------------------
            */
            'input_nilai_uas_mulai' => 'nullable|date',
            'input_nilai_uas_selesai' => 'nullable|date|after:input_nilai_uas_mulai',

            /*
            |--------------------------------------------------------------------------
            | Periode Pengumuman Nilai Final
            |--------------------------------------------------------------------------
            */
            'pengumuman_nilai_final_mulai' => 'nullable|date',
            'pengumuman_nilai_final_selesai' => 'nullable|date|after:pengumuman_nilai_final_mulai',
        ]);

        $data = Metaperiode::first();
        if ($data) {
            $data->update($validated);
        } else {
            Metaperiode::create($validated);
        }
        $this->generateIpsIfAllowed();

        return back()->with('success', 'Data berhasil disimpan.');
    }

        private function generateIpsIfAllowed()
    {
        $meta = Metaperiode::first();

        if (
            !$meta ||
            !$meta->pengumuman_nilai_final_selesai ||
            now()->lte($meta->pengumuman_nilai_final_selesai)
        ) {
            return;
        }

        $mahasiswas = Mahasiswa::all();

        foreach ($mahasiswas as $mahasiswa) {

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
            

            $ips = 0;

            if ($totalSks > 0) {
                $ips = round($totalMutu / $totalSks, 3);
            }

            $maksimalSks = $ips >= 3.000 ? 24 : 21;

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