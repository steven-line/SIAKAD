<?php

namespace App\Http\Controllers\Admin;

use App\Models\Dosen;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; // <-- WAJIB IMPORT INI

class DosenController extends Controller
{
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
        $users = User::whereDoesntHave('roles', function ($query) {
            $query->where('name', 'admin');
        })->whereDoesntHave('dosen')->get(); 

        $prodis = Prodi::all(); 

        return view('admin.dosens.create', [
            'users' => $users,
            'prodis' => $prodis
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nim_dosen' => ['required', 'min:8', 'unique:dosen,nim_dosen'],
            'nip' => ['required', 'min:8', 'unique:dosen,nip'],
            'nama' => ['required', 'max:255'],
            'user_id' => ['required', 'unique:dosen,user_id'], 
            'prodi' => ['required', 'exists:prodi,kode_prodi'] 
        ]);
       
        Dosen::create([
            'nim_dosen' => $request->nim_dosen,
            'nip' => $request->nip,
            'nama' => $request->nama,
            'user_id' => $request->user_id,
            'prodi' => $request->prodi
        ]);

        return redirect('/admin/kelola-dosen');
    }

    public function show(Dosen $dosen)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dosen $dosen)
    {   
        $users = User::whereDoesntHave('roles', function ($query) {
            $query->where('name', 'admin');
        })->where(function($query) use ($dosen) {
            $query->whereDoesntHave('dosen')
                  ->orWhere('username', $dosen->user_id); 
        })->get();

        $prodis = Prodi::all(); 

        return view('admin.dosens.edit', [
            'dosen' => $dosen, 
            'users' => $users,
            'prodis' => $prodis
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dosen $dosen)
    {
        // PERBAIKAN VALIDASI: Menggunakan Rule::unique dengan acuan nim_dosen
        $request->validate([
            'nim_dosen' => [
                'required', 
                Rule::unique('dosen', 'nim_dosen')->ignore($dosen->nim_dosen, 'nim_dosen')
            ],
            'nip' => [
                'required', 
                Rule::unique('dosen', 'nip')->ignore($dosen->nim_dosen, 'nim_dosen')
            ],
            'nama' => ['required', 'max:255'],
            'user_id' => [
                'required', 
                Rule::unique('dosen', 'user_id')->ignore($dosen->nim_dosen, 'nim_dosen')
            ], 
            'prodi' => ['required', 'exists:prodi,kode_prodi']
        ]);

        $dosen->update([
            'nim_dosen' => $request->nim_dosen,
            'nip' => $request->nip,
            'nama' => $request->nama,
            'user_id' => $request->user_id,
            'prodi' => $request->prodi
        ]);
   
        return redirect('/admin/kelola-dosen');
    }

    public function destroy(Dosen $dosen)
    {
        $dosen->delete();
        return redirect('/admin/kelola-dosen')->with('success', 'Dosen Dihapus');
    }
}