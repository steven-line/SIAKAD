<?php

namespace App\Http\Controllers;

use App\Models\Metaperiode;
use App\Models\Periode;
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

        return back()->with('success', 'Data berhasil disimpan.');
    }
}