<?php

namespace App\Http\Controllers;

use App\Models\Metaperiode;
use App\Models\Periode;
use Illuminate\Http\Request;

class MetaperiodeController extends Controller
{
    public function index()
    {
        $periode = Periode::with(['semesters' => function ($q) {
    $q->where('aktif', 1);
}])->where('aktif', 1)->first();
        $metaperiode = Metaperiode::first(); // ambil data kalau ada

        return view('admin.metaperiode.index', compact('metaperiode', 'periode'));
    }

    public function update(Request $request)
    {
        // ✅ VALIDASI
        $validated = $request->validate([
            'periode_id' => 'required|exists:periode,id',

            'krs_mulai' => 'required|date',
            'krs_selesai' => 'required|date|after:krs_mulai',

            'input_nilai_uts_mulai' => 'nullable|date',
            'input_nilai_uts_selesai' => 'nullable|date|after:input_nilai_uts_mulai',

            'input_nilai_uas_mulai' => 'nullable|date',
            'input_nilai_uas_selesai' => 'nullable|date|after:input_nilai_uas_mulai',

            'khs_mulai' => 'nullable|date',
            'khs_selesai' => 'nullable|date|after:khs_mulai',
        ]);

        // ✅ UPDATE ATAU CREATE
        Metaperiode::updateOrCreate(
            ['periode_id' => $validated['periode_id']], // kunci utama
            $validated
        );

        return back()->with('success', 'Data berhasil disimpan');
    }
}