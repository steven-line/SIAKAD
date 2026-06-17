<?php

namespace App\Http\Controllers\Admin;

use App\Models\Mk;
use App\Http\Controllers\Controller;
use App\Models\Kurikulum;
use Illuminate\Http\Request;

class MkController extends Controller
{
    public function index()
    {
        $mks = Mk::paginate(15);
        return view('admin.matakuliah.index', ['mks' => $mks]);
    }

    public function create()
    {
        $kurikulums = Kurikulum::orderby('kode_kurikulum')->get();
        return view('admin.matakuliah.create', ['kurikulums' => $kurikulums]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kodemk' => ['required'],
            'nama' => ['required'],
            'sks' => ['required'],
            'nm_jenj_didik' => ['required'],
            'kode_prodi_dikti' => ['required'],
            'kode_kurikulum' => ['required'],
            'prasyaratsks' => ['required'],
            'prasyarat1' => ['required'],
            'prasyarat2' => ['required'],
            'prasyarat3' => ['required'],
            'prasyarat4' => ['required'],
            'prasyarat5' => ['required'],
            'prasyarat6' => ['required'],
            'prasyarat7' => ['required'],
            'prasyarat8' => ['required'],
            'prasyarat9' => ['required'],
            'prasyarat10' => ['required'],
            'prasyaratgrade' => ['required'], 
        ]);

        Mk::create([
            'kodemk' => $request->kodemk,
            'nama' => $request->nama,
            'sks' => $request->sks,
            'nm_jenj_didik' => $request->nm_jenj_didik,
            'kode_prodi_dikti' => $request->kode_prodi_dikti,
            'kode_kurikulum' => $request->kode_kurikulum,
            'prasyaratsks' => $request->prasyaratsks,
            'prasyarat1' => $request->prasyarat1,
            'prasyarat2' => $request->prasyarat2,
            'prasyarat3' => $request->prasyarat3,
            'prasyarat4' => $request->prasyarat4,
            'prasyarat5' => $request->prasyarat5,
            'prasyarat6' => $request->prasyarat6,
            'prasyarat7' => $request->prasyarat7,
            'prasyarat8' => $request->prasyarat8,
            'prasyarat9' => $request->prasyarat9,
            'prasyarat10' => $request->prasyarat10,
            'prasyaratgrade' => $request->prasyaratgrade,
            'aktif' => $request->boolean('aktif'),
        ]);

        return redirect()->route('mk.index');
    }

    public function show(Mk $mk)
    {
        return view('admin.matakuliah.show', ['mk' => $mk]);
    }

    public function edit(Mk $mk)
    {
        $kurikulums = Kurikulum::orderby('kode_kurikulum')->get();
        return view('admin.matakuliah.edit', [
            'mk' => $mk,
            'kurikulums' => $kurikulums
        ]);
    }

    public function update(Request $request, Mk $mk)
    {
        $mk->update([
            'kodemk' => $request->kodemk,
            'nama' => $request->nama,
            'sks' => $request->sks,
            'nm_jenj_didik' => $request->nm_jenj_didik,
            'kode_prodi_dikti' => $request->kode_prodi_dikti,
            'kode_kurikulum' => $request->kode_kurikulum,
            'prasyaratsks' => $request->prasyaratsks,
            'prasyarat1' => $request->prasyarat1,
            'prasyarat2' => $request->prasyarat2,
            'prasyarat3' => $request->prasyarat3,
            'prasyarat4' => $request->prasyarat4,
            'prasyarat5' => $request->prasyarat5,
            'prasyarat6' => $request->prasyarat6,
            'prasyarat7' => $request->prasyarat7,
            'prasyarat8' => $request->prasyarat8,
            'prasyarat9' => $request->prasyarat9,
            'prasyarat10' => $request->prasyarat10,
            'prasyaratgrade' => $request->prasyaratgrade,
            'aktif' => $request->boolean('aktif'),
        ]);

        return redirect()->route('mk.index');
    }

    public function destroy(Mk $mk)
    {
        $mk->delete();

        return redirect()
            ->route('mk.index')
            ->with('success', 'Mata Kuliah Dihapus');
    }
}