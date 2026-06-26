<?php

namespace App\Http\Controllers;

use App\Models\Kurikulum;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KurikulumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kurikulums = Kurikulum::paginate(10);

        return view('admin.kurikulum.index', [
            'kurikulums' => $kurikulums
        ]);
    }

    /**
     * Show create form
     */
    public function create()
    {
        $prodis = Prodi::all();
        return view('admin.kurikulum.create', ['prodis' => $prodis]);
    }

    /**
     * Store new data
     */   
    public function store(Request $request)
    {
        $request->validate([
            'kode_kurikulum' => ['required', 'min:3', 'max:15', 'unique:kurikulum',   'regex:/^[A-Za-z0-9\-]+$/'],
            'nama_kurikulum' => ['required', 'min:4', 'max:50'],
            'deskripsi' => ['required', 'min:20'],
            'tahun_mulai_berlaku' => ['required',  'integer', 'max:'.date('Y')+10],
            'tahun_selesai_berlaku' => ['required',  'integer', 'max:9999'],
            'kode_prodi' => ['required']
        ]);

        Kurikulum::create([
            'kode_kurikulum' => $request->kode_kurikulum,
            'nama_kurikulum' => $request->nama_kurikulum,
            'aktif' => $request->boolean('aktif'),
            'deskripsi' => $request->deskripsi,
            'tahun_mulai_berlaku' => $request->tahun_mulai_berlaku,
            'tahun_selesai_berlaku' => $request->tahun_selesai_berlaku,
            'kode_prodi' => $request->kode_prodi
        ]);

        return redirect()->route('kurikulum.index');
    }

    /**
     * Show detail
     */
    public function show(Kurikulum $kurikulum)
    {
        return view('admin.kurikulum.show', [
            'kurikulum' => $kurikulum
        ]);
    }

    /**
     * Edit form
     */
    public function edit(Kurikulum $kurikulum)
    {
        $prodis = Prodi::all();
        return view('admin.kurikulum.edit', [
            'kurikulum' => $kurikulum,
            'prodis' => $prodis
        ]);
    }

    /**
     * Update data
     */
    public function update(Request $request, Kurikulum $kurikulum)
    {
        $request->validate([
            'kode_kurikulum' => ['required', 'min:3', 'max:15', Rule::unique('kurikulum')->ignore($kurikulum),  'regex:/^[A-Za-z0-9\-]+$/'],
            'nama_kurikulum' => ['required', 'min:4', 'max:50'],
            'deskripsi' => ['required', 'min:20'],
            'tahun_mulai_berlaku' => ['required',  'integer', 'max:'.date('Y')+10],
            'tahun_selesai_berlaku' => ['required',  'integer', 'max:9999'],
            'kode_prodi' => ['required']
        ]);

        $kurikulum->update([
            'kode_kurikulum' => $request->kode_kurikulum,
            'nama_kurikulum' => $request->nama_kurikulum,
            'aktif' => $request->boolean('aktif'),
            'deskripsi' => $request->deskripsi,
            'tahun_mulai_berlaku' => $request->tahun_mulai_berlaku,
            'tahun_selesai_berlaku' => $request->tahun_selesai_berlaku,
            'kode_prodi' => $request->kode_prodi
        ]);

        return redirect()->route('kurikulum.index');
    }

    /**
     * Delete data
     */
    public function destroy(Kurikulum $kurikulum)
    {
        $kurikulum->delete();

        return redirect()
            ->route('kurikulum.index')
            ->with('success', 'Kurikulum berhasil dihapus');
    }
}