<?php

namespace App\Http\Controllers\Admin;

use App\Models\Dosen;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DosenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dosens = Dosen::paginate(15);
        return view('admin.dosens.index', ['dosens' => $dosens]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.dosens.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nim_dosen' => ['required', 'min:8'],
            'nip' => ['required', 'min:8'],
            'nama' => ['required', 'max:255'],
        ]);

        Dosen::create([
            'nim_dosen' => $request->nim_dosen,
            'nip' => $request->nip,
            'nama' => $request->nama
        ]);
        return redirect('/admin/kelola-dosen');
    }

    /**
     * Display the specified resource.
     */
    public function show(Dosen $dosen)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dosen $dosen)
    {   
        return view('admin.dosens.edit', ['dosen' => $dosen]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dosen $dosen)
    {
        $dosen->update([
            'nim_dosen' => $request->nim_dosen,
            'nip' => $request->nip,
            'nama' => $request->nama]);

        return redirect('/admin/kelola-dosen');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dosen $dosen)
    {
        $dosen->delete();
        return redirect('/admin/kelola-dosen')->with('success', 'Dosen Dihapus');
    }
}
