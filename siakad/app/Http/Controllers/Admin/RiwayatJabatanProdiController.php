<?php

namespace App\Http\Controllers;

use App\Models\RiwayatJabatanProdi;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RiwayatJabatanProdiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $riwayats = RiwayatJabatanProdi::paginate(15);
        return view('admin.riwayat_jabatan_prodi.index', ['riwayats' => $riwayats]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.riwayat_jabatan_prodi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
          $request->validate([
            'kode_prodi' => ['required', 'min:3'],
            'nama_prodi' => ['required', 'min:4']
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(RiwayatJabatanProdi $riwayatJabatanProdi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RiwayatJabatanProdi $riwayatJabatanProdi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RiwayatJabatanProdi $riwayatJabatanProdi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RiwayatJabatanProdi $riwayatJabatanProdi)
    {
        //
    }
}
