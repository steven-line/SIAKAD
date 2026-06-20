<?php

namespace App\Http\Controllers\Admin;

use App\Models\Mk;
use App\Http\Controllers\Controller;
use App\Models\Kurikulum;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MkController extends Controller
{
    public function index()
    {
        $mks = Mk::paginate('15');
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
            'kodemk' => ['required', 'unique:mk', 'max:8'],
            'nama' => ['required', 'max:50'],
            'sks' => ['required','max:3'],
            'nm_jenj_didik' => ['required', 'max:2'],
            'kode_prodi_dikti' => ['required', 'max:5'],
            'kode_kurikulum' => ['required', 'max:10'],
            'prasyaratsks' => ['required', 'max:3'],
            'prasyarat1' => ['required', 'max:8'],
            'prasyarat2' => ['required', 'max:8'],
            'prasyarat3' => ['required', 'max:8'],
            'prasyarat4' => ['required', 'max:8'],
            'prasyarat5' => ['required', 'max:8'],
            'prasyarat6' => ['required', 'max:8'],
            'prasyarat7' => ['required', 'max:8'],
            'prasyarat8' => ['required', 'max:8'],
            'prasyarat9' => ['required', 'max:8'],
            'prasyarat10' => ['required', 'max:8'],
            'prasyaratgrade' => ['required', 'max:1'], 
         
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
         $request->validate([
            'kodemk' => ['required', 'max:8', Rule::unique('mk')->ignore($mk)],
            'nama' => ['required', 'max:50'],
            'sks' => ['required','max:3'],
            'nm_jenj_didik' => ['required', 'max:2'],
            'kode_prodi_dikti' => ['required', 'max:5'],
            'kode_kurikulum' => ['required', 'max:10'],
            'prasyaratsks' => ['required', 'max:3'],
            'prasyarat1' => ['required', 'max:8'],
            'prasyarat2' => ['required', 'max:8'],
            'prasyarat3' => ['required', 'max:8'],
            'prasyarat4' => ['required', 'max:8'],
            'prasyarat5' => ['required', 'max:8'],
            'prasyarat6' => ['required', 'max:8'],
            'prasyarat7' => ['required', 'max:8'],
            'prasyarat8' => ['required', 'max:8'],
            'prasyarat9' => ['required', 'max:8'],
            'prasyarat10' => ['required', 'max:8'],
            'prasyaratgrade' => ['required', 'max:1'], 
           
        ]);

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