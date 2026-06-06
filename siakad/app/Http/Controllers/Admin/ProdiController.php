<?php

namespace App\Http\Controllers\Admin;

use App\Models\Prodi;
use App\Http\Controllers\Controller;
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
        return view('admin.prodi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_prodi' => ['required', 'min:3'],
            'nama_prodi' => ['required', 'min:4'],
        ]);
        Prodi::create([
            'kode_prodi' => $request->kode_prodi,
            'nama_prodi' => $request->nama_prodi
        ]);
        return redirect('/admin/kelola-prodi');
        
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
        return view('admin.prodi.edit', ['prodi' => $prodi]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Prodi $prodi)
    {
        $prodi->update([
            'kode_prodi' => $request->kode_prodi,
            'nama_prodi' => $request->nama_prodi,
        ]);

        return redirect('/admin/kelola-prodi');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Prodi $prodi)
    {
        
     $prodi->delete();
        return redirect('/admin/kelola-prodi')->with('success', 'Prodi Dihapus');
   
    }
}
