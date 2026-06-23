<?php

namespace App\Http\Controllers;

use App\Models\Periode;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PeriodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
          $periodes = Periode::paginate(10);

        return view('admin.periode.index', [
            'periodes' => $periodes
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.periode.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tahun_ajaran' => ['required', 'size:9'],
            'tanggal_mulai' => ['required',  Rule::date()->format('Y-m-d')],
            'tanggal_selesai' => ['required', Rule::date()->format('Y-m-d'),],
        ]);

        Periode::create([
            'tahun_ajaran' => $request->tahun_ajaran,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' =>  $request->tanggal_selesai,
        ]);

        return redirect()->route('periode.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Periode $periode)
    {
        return view('admin.periode.show', ['periode' => $periode]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Periode $periode)
    {
       return view('admin.periode.edit', ['periode' => $periode]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Periode $periode)
    {
        $request->validate([
            'tahun_ajaran' => ['required', 'size:9'],
            'tanggal_mulai' => ['required',  Rule::date()->format('Y-m-d')],
            'tanggal_selesai' => ['required', Rule::date()->format('Y-m-d'),],
        ]);

        $periode->update([
            'tahun_ajaran' => $request->tahun_ajaran,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' =>  $request->tanggal_selesai,
        ]);

        return redirect()->route('periode.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Periode $periode)
    {
        //
         $periode->delete();
          return redirect()->route('periode.index')->with('success', 'Periode Dihapus');
   
    }
}
