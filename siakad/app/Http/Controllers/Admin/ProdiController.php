<?php

namespace App\Http\Controllers\Admin;

use App\Models\Prodi;
use App\Http\Controllers\Controller;
use App\Models\Fakultas;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProdiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prodis = Prodi::paginate(10);
        return view('admin.prodi.index', ['prodis' => $prodis]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jurusans = Jurusan::all();
        return view('admin.prodi.create', ['jurusans' => $jurusans]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_prodi' => ['required', 'min:3', 'unique:prodi', 'max:15'],
            'nama_prodi' => ['required', 'min:4', 'max:50'],
            'kode_jurusan' => ['required', 'max:3']
        ]);

        Prodi::create([
            'kode_prodi' => $request->kode_prodi,
            'nama_prodi' => $request->nama_prodi,
            'kode_jurusan' => $request->kode_jurusan,
        ]);

        return redirect()->route('prodi.index')
            ->with('success', 'Prodi berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Prodi $prodi)
    {
        $jurusans = Jurusan::all();

        return view('admin.prodi.edit', [
            'prodi' => $prodi,
            'jurusans' => $jurusans
        ]);
    }
     public function show(Prodi $prodi)
    {
        

        return view('admin.prodi.show', [
            'prodi' => $prodi,

        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Prodi $prodi)
    {
        $request->validate([
            'kode_prodi' => ['required', 'min:3', Rule::unique('prodi')->ignore($prodi), 'max:15'],
            'nama_prodi' => ['required', 'min:4', 'max:50'],
            'kode_jurusan' => ['required', 'max:3']
        ]);
        $prodi->update([
            'kode_prodi' => $request->kode_prodi,
            'nama_prodi' => $request->nama_prodi,
            'kode_jurusan' => $request->kode_jurusan,
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