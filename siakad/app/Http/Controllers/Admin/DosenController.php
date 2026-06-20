<?php

namespace App\Http\Controllers\Admin;

use App\Models\Dosen;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DosenController extends Controller
{
    public function index()
    {
        $dosens = Dosen::paginate(15);

        return view('admin.dosens.index', [
            'dosens' => $dosens
        ]);
    }

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

    public function store(Request $request)
    {
        $request->validate([
            'nim_dosen' => ['required', 'min:8', 'unique:dosen,nim_dosen', 'max:15'],
            'nip' => ['required', 'min:8', 'unique:dosen,nip', 'max:21'],
            'nama' => ['required', 'max:50'],
            'user_id' => ['required', 'unique:dosen,user_id'],
            'prodi' => ['required', 'exists:prodi,kode_prodi'],
            'jabatan_struktural' => ['required', 'max:100']
        ]);

        Dosen::create([
            'nim_dosen' => $request->nim_dosen,
            'nip' => $request->nip,
            'nama' => $request->nama,
            'user_id' => $request->user_id,
            'prodi' => $request->prodi,
            'jabatan_struktural' => $request->jabatan_struktural
        ]);

        return redirect()->route('dosen.index');
    }

    public function show(Dosen $dosen)
    {
       
        return view('admin.dosens.show', [
            'dosen' => $dosen,
          
        ]);
    }

    public function edit(Dosen $dosen)
    {
        $users = User::whereDoesntHave('roles', function ($query) {
            $query->where('name', 'admin');
        })->where(function ($query) use ($dosen) {
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

    public function update(Request $request, Dosen $dosen)
    {
        $request->validate([
            'nim_dosen' => [
                'required',
                'max:15',
                Rule::unique('dosen', 'nim_dosen')->ignore($dosen->nim_dosen, 'nim_dosen')
            ],
            'nip' => [
                'required',
                'max:21',
                Rule::unique('dosen', 'nip')->ignore($dosen->nim_dosen, 'nim_dosen')
            ],
            'nama' => ['required', 'max:50'],
            'user_id' => [
                'required',
                Rule::unique('dosen', 'user_id')->ignore($dosen->nim_dosen, 'nim_dosen')
            ],
            'prodi' => ['required', 'exists:prodi,kode_prodi'],
            'jabatan_struktural' => ['required', 'max:100']
        ]);

        $dosen->update([
            'nim_dosen' => $request->nim_dosen,
            'nip' => $request->nip,
            'nama' => $request->nama,
            'user_id' => $request->user_id,
            'prodi' => $request->prodi,
            'jabatan_struktural' => $request->jabatan_struktural
        ]);

        return redirect()->route('dosen.index');
    }

    public function destroy(Dosen $dosen)
    {
        $dosen->delete();

        return redirect()
            ->route('dosen.index')
            ->with('success', 'Dosen Dihapus');
    }
}