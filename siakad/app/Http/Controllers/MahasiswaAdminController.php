<?php

namespace App\Http\Controllers;

use App\Enums\StatusBlokir;
use App\Models\Mahasiswa;
use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\Prodi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MahasiswaAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mahasiswas = Mahasiswa::with('dosenwali')->paginate('10');

        return view('admin.mahasiswas.index', ['mahasiswas' => $mahasiswas]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::role('mahasiswa')->whereDoesntHave('dosen')->whereDoesntHave('mahasiswa')->get();
        $dosens = Dosen::all();
        $prodis = Prodi::all();
        return view('admin.mahasiswas.create', ['users' => $users, 'dosens' => $dosens, 'prodis' => $prodis]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nrp' => ['required', 'unique:mahasiswas'],
            'dosen_wali' => ['required'],
            'status_blokir' => ['required', Rule::enum(StatusBlokir::class)],
            'prodi' => ['required']

        ]);
        Mahasiswa::create([
            'nrp' => $request->nrp,
            'dosen_wali' => $request->dosen_wali,
            'status_blokir' => $request->status_blokir,
            'prodi' => $request->prodi
        ]);
        
        return redirect()
        ->route('mahasiswa_admin.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Mahasiswa $mahasiswa)
    {
        return view('admin.mahasiswas.show', ['mahasiswa' => $mahasiswa]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mahasiswa $mahasiswa)
    {

        $users =  User::role('mahasiswa')
        ->whereDoesntHave('dosen')
        ->whereDoesntHave('mahasiswa')->orWhere('username', '=', $mahasiswa->nrp)
    
        ->get();
        $dosens = Dosen::all();
        $prodis = Prodi::all();
        return view('admin.mahasiswas.edit', ['users' => $users, 'dosens' => $dosens, 'prodis' => $prodis, 'mahasiswa' => $mahasiswa]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        $request->validate([
            'nrp' => ['required', 'min:8', 'max:191',Rule::unique('mahasiswas')->ignore($mahasiswa)],
            'dosen_wali' => ['required'],
            'status_blokir' => ['required', Rule::enum(StatusBlokir::class)],
            'prodi' => ['required']

        ]);

        $mahasiswa->update([
            'nrp' => $request->nrp,
            'dosen_wali' => $request->dosen_wali,
            'status_blokir' => $request->status_blokir,
            'prodi' => $request->prodi
        ]);
        
        return redirect()
        ->route('mahasiswa_admin.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mahasiswa $mahasiswa)
    {
          $mahasiswa->delete();
          return redirect()->route('mahasiswa_admin.index')->with('success', 'Mahasiswa Dihapus');
   
    }
}
