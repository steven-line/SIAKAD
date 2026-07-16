<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\Fakultas;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class JurusanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jurusans = Jurusan::with('fakultas')->paginate(10);

        return view('admin.jurusan.index', [
            'jurusans' => $jurusans
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $fakultass = Fakultas::all();

        return view('admin.jurusan.create', [
            'fakultass' => $fakultass
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_jurusan' => ['required', 'min:3', 'max:3', 'unique:jurusan,kode_jurusan', 'regex:/^[A-Za-z0-9\-]+$/'],
            'nama_jurusan' => ['nullable', 'min:4', 'max:50'],
            'program_pendidikan' => ['required', 'min:2', 'max:50'],
            'sk_ban' => ['required', 'min:4', 'max:50'],
            'keterangan' => ['nullable', 'max:255'],
            'kode_fakultas' => ['required', 'exists:fakultas,kode_fakultas'],
        ]);

        Jurusan::create([
            'kode_jurusan' => $request->kode_jurusan,
            'nama_jurusan' => $request->nama_jurusan,
            'program_pendidikan' => $request->program_pendidikan,
            'sk_ban' => $request->sk_ban,
            'keterangan' => $request->keterangan,
            'kode_fakultas' => $request->kode_fakultas,
        ]);

        return redirect()->route('jurusan.index')
            ->with('success', 'Jurusan berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Jurusan $jurusan)
    {
        $jurusan->load('fakultas');

        return view('admin.jurusan.show', [
            'jurusan' => $jurusan
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jurusan $jurusan)
    {
        $fakultass = Fakultas::all();

        return view('admin.jurusan.edit', [
            'jurusan' => $jurusan,
            'fakultass' => $fakultass
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Jurusan $jurusan)
    {
        $request->validate([
            'kode_jurusan' => [
                'required',
                'min:3',
                'max:3',
                Rule::unique('jurusan', 'kode_jurusan')->ignore($jurusan->kode_jurusan, 'kode_jurusan'), 'regex:/^[A-Za-z0-9\-]+$/'
            ],
            'nama_jurusan' => ['nullable', 'min:4', 'max:50'],
            'program_pendidikan' => ['required', 'min:2', 'max:50'],
            'sk_ban' => ['required', 'min:4', 'max:50'],
            'keterangan' => ['nullable', 'max:255'],
            'kode_fakultas' => ['required', 'exists:fakultas,kode_fakultas'],
        ]);

        $jurusan->update([
            'kode_jurusan' => $request->kode_jurusan,
            'nama_jurusan' => $request->nama_jurusan,
            'program_pendidikan' => $request->program_pendidikan,
            'sk_ban' => $request->sk_ban,
            'keterangan' => $request->keterangan,
            'kode_fakultas' => $request->kode_fakultas,
        ]);

        return redirect()->route('jurusan.index')
            ->with('success', 'Jurusan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jurusan $jurusan)
    {
        $jurusan->delete();

        return redirect()->route('jurusan.index')
            ->with('success', 'Jurusan dihapus');
    }
}