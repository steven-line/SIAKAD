<?php

namespace App\Http\Controllers;

use App\Models\Fakultas;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FakultasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fakultass = Fakultas::paginate(10);

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
            'nama_fakultas' => ['required', 'min:4', 'max:50'],
        ]);

        Fakultas::create([
            'nama_fakultas' => $request->nama_fakultas,
        ]);

        return redirect()->route('fakultas.index')
            ->with('success', 'Fakultas berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Fakultas $fakultas)
    {
        return view('admin.fakultas.show', [
            'fakultas' => $fakultas
        ]);
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
        $request->validate([
            'nama_fakultas' => ['required', 'min:4', 'max:50'],
        ]);
        $fakultas->update([
            'nama_fakultas' => $request->nama_fakultas,
        ]);

        return redirect()->route('fakultas.index')
            ->with('success', 'Fakultas berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    
    public function destroy(Fakultas $fakultas)
    {
        $fakultas->delete();

        return redirect()->route('fakultas.index')
            ->with('success', 'Fakultas Dihapus');
    }
}