<?php

namespace App\Http\Controllers;

use App\Models\Fakultas;
use Illuminate\Http\Request;

class FakultasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fakultass = Fakultas::paginate(15);

        return view('admin.fakultas.index', [
            'fakultass' => $fakultass
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.fakultas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_fakultas' => ['required', 'min:3'],
            'nama_fakultas' => ['required', 'min:4'],
        ]);

        Fakultas::create([
            'kode_fakultas' => $request->kode_fakultas,
            'nama_fakultas' => $request->nama_fakultas,
        ]);

        return redirect('/admin/kelola-fakultas');
    }

    /**
     * Display the specified resource.
     */
    public function show(Fakultas $fakultas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Fakultas $fakultas)
    {
        return view('admin.fakultas.edit', [
            'fakultas' => $fakultas
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Fakultas $fakultas)
    {
        $fakultas->update([
            'kode_fakultas' => $request->kode_fakultas,
            'nama_fakultas' => $request->nama_fakultas,
        ]);

        return redirect('/admin/kelola-fakultas');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fakultas $fakultas)
    {
        $fakultas->delete();

        return redirect('/admin/kelola-fakultas')
            ->with('success', 'Fakultas Dihapus');
    }
}