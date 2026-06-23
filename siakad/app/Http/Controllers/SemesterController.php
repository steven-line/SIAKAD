<?php

namespace App\Http\Controllers;

use App\Enums\JenisSemester;
use App\Models\Semester;
use App\Http\Controllers\Controller;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SemesterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $semesters = Semester::paginate(10);

        return view('admin.semester.index', [
            'semesters' => $semesters
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $periodes = Periode::all();
        return view('admin.semester.create', ['periodes' => $periodes]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'periode_id' => ['required'],
            'jenis' => ['required', Rule::enum(JenisSemester::class)],
    
        ]);

        Semester::create([
            'periode_id' => $request->periode_id,
            'jenis' => $request->jenis,
            'aktif' => $request->boolean('aktif')
        ]);

        return redirect()->route('semester.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Semester $semester)
    {
        //
        return view('admin.semester.show', ['semester' => $semester]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Semester $semester)
    {
        $periodes = Periode::all();
        return view('admin.semester.edit', ['semester' => $semester, 'periodes' => $periodes]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Semester $semester)
    {
        //
         $request->validate([
            'periode_id' => ['required'],
            'jenis' => ['required', Rule::enum(JenisSemester::class)],
         
        ]);

        $semester->update([
            'periode_id' => $request->periode_id,
            'jenis' => $request->jenis,
            'aktif' => $request->boolean('aktif')
        ]);

        return redirect()->route('semester.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Semester $semester)
    {
         $semester->delete();
        return redirect()->route('semester.index')->with('success', 'Semester Dihapus');
   
    }
}
