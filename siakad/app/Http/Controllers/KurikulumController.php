<?php

namespace App\Http\Controllers;

use App\Models\Kurikulum;
use Illuminate\Http\Request;

class KurikulumController extends Controller
{
    /**
     * Display a listing of the resource.
     */public function index()
    {
        $kurikulums = Kurikulum::paginate(15);
        return view('admin.kurikulum.index', ['kurikulums' => $kurikulums]);
   
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.kurikulum.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_kurikulum' => ['required', 'min:3'],
            'nama_kurikulum' => ['required', 'min:4'],
            'deskripsi' => ['required', 'min:20'],
            'tahun_mulai_berlaku' => ['required'],
            'tahun_selesai_berlaku' => ['required'],

        ]);
        Kurikulum::create([
            'kode_kurikulum' => $request->kode_kurikulum,
            'nama_kurikulum' => $request->nama_kurikulum,
            'aktif'          => $request->boolean('aktif'), 
            'deskripsi' => $request->deskripsi,
            'tahun_mulai_berlaku' => $request->tahun_mulai_berlaku,
            'tahun_selesai_berlaku' => $request->tahun_selesai_berlaku,
      
        ]);
        return redirect('/admin/kelola-kurikulum');
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Kurikulum $kurikulum)
    {
        //
        return view('admin.kurikulum.show', ['kurikulum' => $kurikulum]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kurikulum $kurikulum)
    {
        return view('admin.kurikulum.edit', ['kurikulum' => $kurikulum]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kurikulum $kurikulum)
    {
        $kurikulum->update([
            'kode_kurikulum' => $request->kode_kurikulum,
            'nama_kurikulum' => $request->nama_kurikulum,
            'aktif'          => $request->boolean('aktif'),
            'deskripsi' => $request->deskripsi,
            'tahun_mulai_berlaku' => $request->tahun_mulai_berlaku,
            'tahun_selesai_berlaku' => $request->tahun_selesai_berlaku,

        ]);

        return redirect('/admin/kelola-kurikulum');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kurikulum $kurikulum)
    {
        
     $kurikulum->delete();
        return redirect('/admin/kelola-kurikulum')->with('success', 'kurikulum Dihapus');
   
    }
}

