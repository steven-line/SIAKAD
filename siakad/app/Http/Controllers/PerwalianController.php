<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class PerwalianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
    
        $nimDosen = auth()->user()->dosen->nim_dosen;

            $mahasiswas = Mahasiswa::with('dosenWali')
                ->where('dosen_wali', $nimDosen)
                ->get();

            return view(
                'dosen_wali.perwalian.index',
                ['mahasiswas' => $mahasiswas]
            );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Mahasiswa $mahasiswa)
    {
        
        return view('dosen_wali.perwalian.show', ['mahasiswa' => $mahasiswa]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
