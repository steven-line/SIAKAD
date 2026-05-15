<?php

namespace App\Http\Controllers\Admin;

use App\Models\Mk;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mks = Mk::paginate(15);
        return view('admin.matakuliah.index', ['mks' => $mks]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.matakuliah.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kodemk' => ['required'],
            'nama' => ['required'],
            'sks' => ['required'],
            'nm_jenj_didik' => ['required'],
            'kode_prodi_dikti' => ['required'],
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
        ]);
        return redirect('/admin/kelola-matakuliah');

    }

    /**
     * Display the specified resource.
     */
    public function show(Mk $mk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mk $mk)
    {

        return view('admin.matakuliah.edit', ['mk' => $mk]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mk $mk)
    {
        $mk->update([    'kodemk' => $request->kodemk,
            'nama' => $request->nama,
            'sks' => $request->sks,
            'nm_jenj_didik' => $request->nm_jenj_didik,
            'kode_prodi_dikti' => $request->kode_prodi_dikti,
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
            ]);
            
            return redirect('/admin/kelola-matakuliah');
            
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mk $mk)
    {
        $mk->delete();
        return redirect('/admin/kelola-matakuliah')->with('success', 'Mata Kuliah Dihapus');
    }
}
