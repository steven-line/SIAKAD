<?php

namespace App\Http\Controllers\Admin;

use App\Models\Prodi;
use App\Http\Controllers\Controller;
use App\Models\Fakultas;
use Illuminate\Http\Request;

class ProdiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prodis = Prodi::paginate(15);
        return view('admin.prodi.index', ['prodis' => $prodis]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $fakultass = Fakultas::orderBy('kode_fakultas')->get();
        return view('admin.prodi.create', ['fakultass' => $fakultass]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_prodi' => ['required', 'min:3'],
            'nama_prodi' => ['required', 'min:4'],
            'kode_fakultas' => ['required']
        ]);

        Prodi::create([
            'kode_prodi' => $request->kode_prodi,
            'nama_prodi' => $request->nama_prodi,
            'kode_fakultas' => $request->kode_fakultas,
        ]);

        return redirect()->route('prodi.index')
            ->with('success', 'Prodi berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Prodi $prodi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Prodi $prodi)
    {
        $fakultass = Fakultas::orderBy('kode_fakultas')->get();

        return view('admin.prodi.edit', [
            'prodi' => $prodi,
            'fakultass' => $fakultass
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Prodi $prodi)
    {
        $prodi->update([
            'kode_prodi' => $request->kode_prodi,
            'nama_prodi' => $request->nama_prodi,
            'kode_fakultas' => $request->kode_fakultas,
        ]);

        return redirect()->route('prodi.index')
            ->with('success', 'Prodi berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Prodi $prodi)
    {
        $prodi->delete();

        return redirect()->route('prodi.index')
            ->with('success', 'Prodi Dihapus');
    }
}