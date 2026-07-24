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
        $mks = Mk::paginate('10');
        return view('admin.matakuliah.index', ['mks' => $mks]);
    }

    public function create()
    {
        $kurikulums = Kurikulum::orderby('kode_kurikulum')->get();
        $mks = Mk::with(['kurikulum'])->get();
        return view('admin.matakuliah.create', ['kurikulums' => $kurikulums, 
        'mks' => $mks]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kodemk' => ['required', 'unique:mk', 'max:8',  'regex:/^[A-Za-z0-9\-]+$/'],
            'nama' => ['required', 'max:50'],
            'sks' => ['required','max:3'],
            'nm_jenj_didik' => ['required', 'max:2'],
            'kode_kurikulum' => ['required', 'max:10'],
            'prasyaratsks' => ['required', 'max:3'],
            'prasyarat1' => ['max:8'],
            'prasyarat2' => ['max:8'],
            'prasyarat3' => ['max:8'],
            'prasyarat4' => ['max:8'],
            'prasyarat5' => ['max:8'],
            'prasyarat6' => ['max:8'],
            'prasyarat7' => ['max:8'],
            'prasyarat8' => ['max:8'],
            'prasyarat9' => ['max:8'],
            'prasyarat10' => ['max:8'],
            'prasyaratgrade' => ['required', 'max:1'], 
         
        ]);

        Mk::create([
            'kodemk' => $request->kodemk,
            'nama' => $request->nama,
            'sks' => $request->sks,
            'nm_jenj_didik' => $request->nm_jenj_didik,
            'kode_kurikulum' => $request->kode_kurikulum,
            'prasyaratsks' => $request->prasyaratsks,
            'prasyarat1' => $request->prasyarat1 ?? '-',
            'prasyarat2' => $request->prasyarat2 ?? '-',
            'prasyarat3' => $request->prasyarat3 ?? '-',
            'prasyarat4' => $request->prasyarat4 ?? '-',
            'prasyarat5' => $request->prasyarat5 ?? '-',
            'prasyarat6' => $request->prasyarat6 ?? '-',
            'prasyarat7' => $request->prasyarat7 ?? '-',
            'prasyarat8' => $request->prasyarat8 ?? '-',
            'prasyarat9' => $request->prasyarat9 ?? '-',
            'prasyarat10' => $request->prasyarat10 ?? '-',
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
        $mks = Mk::with(['kurikulum'])->get();
        return view('admin.matakuliah.edit', [
            'mk' => $mk,
            'kurikulums' => $kurikulums,
            'mks' => $mks
        ]);
    }

    public function update(Request $request, Mk $mk)
    {
         $request->validate([
            'kodemk' => ['required', 'max:8', Rule::unique('mk')->ignore($mk),  'regex:/^[A-Za-z0-9\-]+$/'],
            'nama' => ['required', 'max:50'],
            'sks' => ['required','max:3'],
            'nm_jenj_didik' => ['required', 'max:2'],
            'kode_kurikulum' => ['required', 'max:10'],
            'prasyaratsks' => ['required', 'max:3'],
            'prasyarat1' => ['max:8'],
            'prasyarat2' => ['max:8'],
            'prasyarat3' => ['max:8'],
            'prasyarat4' => ['max:8'],
            'prasyarat5' => ['max:8'],
            'prasyarat6' => ['max:8'],
            'prasyarat7' => ['max:8'],
            'prasyarat8' => ['max:8'],
            'prasyarat9' => ['max:8'],
            'prasyarat10' => ['max:8'],
            'prasyaratgrade' => ['required','max:1'], 
           
        ]);

        $mk->update([
            'kodemk' => $request->kodemk,
            'nama' => $request->nama,
            'sks' => $request->sks,
            'nm_jenj_didik' => $request->nm_jenj_didik,
            'kode_kurikulum' => $request->kode_kurikulum,
            'prasyaratsks' => $request->prasyaratsks,
            'prasyarat1' => $request->prasyarat1 ?? '-',
            'prasyarat2' => $request->prasyarat2 ?? '-',
            'prasyarat3' => $request->prasyarat3 ?? '-',
            'prasyarat4' => $request->prasyarat4 ?? '-',
            'prasyarat5' => $request->prasyarat5 ?? '-',
            'prasyarat6' => $request->prasyarat6 ?? '-',
            'prasyarat7' => $request->prasyarat7 ?? '-',
            'prasyarat8' => $request->prasyarat8 ?? '-',
            'prasyarat9' => $request->prasyarat9 ?? '-',
            'prasyarat10' => $request->prasyarat10 ?? '-',
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