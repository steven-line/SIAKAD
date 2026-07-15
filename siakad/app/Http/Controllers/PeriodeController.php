<?php

namespace App\Http\Controllers;

use App\Models\Periode;
use App\Http\Controllers\Controller;
use App\Models\Semester;
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

        $periode = Periode::create([
            'tahun_ajaran' => $request->tahun_ajaran,
            'aktif' => false,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' =>  $request->tanggal_selesai,
        ]);
          $dataSemester = [];

    // Ganjil
     foreach ([1,3,5,7] as $smt) {
            $dataSemester[] = [
            'periode_id' => $periode->id,
            'nama' => (string)$smt,
            'jenis' => 'Ganjil',
            'aktif' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        }

    // Genap
        foreach ([2,4,6,8] as $smt) {
            $dataSemester[] = [
                'periode_id' => $periode->id,
                'nama' => (string)$smt,
                'jenis' => 'Genap',
                'aktif' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Semester::insert($dataSemester);
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
 

    /**
     * Remove the specified resource from storage.
     */
    public function aktifkanSemester(Periode $periode, $jenis)
        {
            $jenis = ucfirst(strtolower($jenis));

            if (!in_array($jenis, ['Ganjil', 'Genap'])) {
                abort(404);
            }

            $periode->aktifkanSemester($jenis);

            return back()->with('success', "Semester {$jenis} aktif");
        }

    public function periodeAktif(Periode $periode) {
        Periode::query()->update([
            'aktif' => false
        ]);

        // 2. Aktifkan periode yang dipilih
        $periode->update([
            'aktif' => true
        ]);
       
        return redirect()->route('periode.index')->with('success', 'Periode diaktifkan');
    }
 
    public function destroy(Periode $periode)
    {
        //
         $periode->delete();
          return redirect()->route('periode.index')->with('success', 'Periode Dihapus');
   
    }
}
