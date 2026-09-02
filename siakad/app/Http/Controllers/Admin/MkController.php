<?php

namespace App\Http\Controllers\Admin;

use App\Models\Mk;
use App\Http\Controllers\Controller;
use App\Imports\MkImport;
use App\Models\Kurikulum;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class MkController extends Controller
{
    /**
     * Menampilkan daftar mata kuliah.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $mks = Mk::when($search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('kodemk', 'like', '%' . $search . '%')
                  ->orWhere('nama', 'like', '%' . $search . '%');
            });
        })
        ->paginate(10)
        ->withQueryString();

        return view(
            'admin.matakuliah.index',
            compact('mks', 'search')
        );
    }


    /**
     * Form tambah mata kuliah.
     */
    public function create()
    {
        $kurikulums = Kurikulum::orderBy('kode_kurikulum')->get();

        $mks = Mk::with('kurikulum')->get();

        return view(
            'admin.matakuliah.create',
            compact('kurikulums', 'mks')
        );
    }


    /**
     * Menyimpan mata kuliah baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([

            'kodemk' => [
                'required',
                'unique:mk,kodemk',
                'max:8',
                'regex:/^[A-Za-z0-9\-]+$/',
            ],

            'nama' => [
                'required',
                'max:50',
            ],

            'sks' => [
                'required',
                'max:3',
            ],

            'nm_jenj_didik' => [
                'required',
                'max:2',
            ],

            'kode_kurikulum' => [
                'required',
                'max:15',
                'exists:kurikulum,kode_kurikulum',
            ],

            /*
             * normal  = PJMK ditentukan Kaprodi
             * khusus  = PJMK ditentukan Admin
             */
            'jenis' => [
                'required',
                'in:normal,khusus',
            ],

            'prasyaratsks' => [
                'required',
                'max:3',
            ],

            'prasyarat1' => ['nullable', 'max:8'],
            'prasyarat2' => ['nullable', 'max:8'],
            'prasyarat3' => ['nullable', 'max:8'],
            'prasyarat4' => ['nullable', 'max:8'],
            'prasyarat5' => ['nullable', 'max:8'],
            'prasyarat6' => ['nullable', 'max:8'],
            'prasyarat7' => ['nullable', 'max:8'],
            'prasyarat8' => ['nullable', 'max:8'],
            'prasyarat9' => ['nullable', 'max:8'],
            'prasyarat10' => ['nullable', 'max:8'],

            'prasyaratgrade' => [
                'required',
                'max:1',
            ],
        ]);


        Mk::create([
            'kodemk' => $validated['kodemk'],
            'nama' => $validated['nama'],
            'sks' => $validated['sks'],
            'nm_jenj_didik' => $validated['nm_jenj_didik'],

            'kode_kurikulum' => $validated['kode_kurikulum'],

            // JENIS PJMK
            'jenis' => $validated['jenis'],

            'prasyaratsks' => $validated['prasyaratsks'],

            'prasyarat1' => $request->filled('prasyarat1')
                ? $request->prasyarat1
                : '-',

            'prasyarat2' => $request->filled('prasyarat2')
                ? $request->prasyarat2
                : '-',

            'prasyarat3' => $request->filled('prasyarat3')
                ? $request->prasyarat3
                : '-',

            'prasyarat4' => $request->filled('prasyarat4')
                ? $request->prasyarat4
                : '-',

            'prasyarat5' => $request->filled('prasyarat5')
                ? $request->prasyarat5
                : '-',

            'prasyarat6' => $request->filled('prasyarat6')
                ? $request->prasyarat6
                : '-',

            'prasyarat7' => $request->filled('prasyarat7')
                ? $request->prasyarat7
                : '-',

            'prasyarat8' => $request->filled('prasyarat8')
                ? $request->prasyarat8
                : '-',

            'prasyarat9' => $request->filled('prasyarat9')
                ? $request->prasyarat9
                : '-',

            'prasyarat10' => $request->filled('prasyarat10')
                ? $request->prasyarat10
                : '-',

            'prasyaratgrade' => $validated['prasyaratgrade'],

            'aktif' => $request->boolean('aktif'),
        ]);


        return redirect()
            ->route('mk.index')
            ->with('success', 'Mata Kuliah berhasil ditambahkan.');
    }


    /**
     * Menampilkan detail mata kuliah.
     */
    public function show(Mk $mk)
    {
        return view(
            'admin.matakuliah.show',
            compact('mk')
        );
    }


    /**
     * Form edit mata kuliah.
     */
    public function edit(Mk $mk)
    {
        $kurikulums = Kurikulum::orderBy('kode_kurikulum')->get();

        $mks = Mk::with('kurikulum')->get();

        return view(
            'admin.matakuliah.edit',
            compact('mk', 'kurikulums', 'mks')
        );
    }


    /**
     * Update mata kuliah.
     */
    public function update(Request $request, Mk $mk)
    {
        $validated = $request->validate([

            'kodemk' => [
                'required',
                'max:8',

                Rule::unique('mk', 'kodemk')
                    ->ignore($mk->kodemk, 'kodemk'),

                'regex:/^[A-Za-z0-9\-]+$/',
            ],

            'nama' => [
                'required',
                'max:50',
            ],

            'sks' => [
                'required',
                'max:3',
            ],

            'nm_jenj_didik' => [
                'required',
                'max:2',
            ],

            'kode_kurikulum' => [
                'required',
                'max:15',
                'exists:kurikulum,kode_kurikulum',
            ],

            /*
             * normal  = PJMK Kaprodi
             * khusus  = PJMK Admin
             */
            'jenis' => [
                'required',
                'in:normal,khusus',
            ],

            'prasyaratsks' => [
                'required',
                'max:3',
            ],

            'prasyarat1' => ['nullable', 'max:8'],
            'prasyarat2' => ['nullable', 'max:8'],
            'prasyarat3' => ['nullable', 'max:8'],
            'prasyarat4' => ['nullable', 'max:8'],
            'prasyarat5' => ['nullable', 'max:8'],
            'prasyarat6' => ['nullable', 'max:8'],
            'prasyarat7' => ['nullable', 'max:8'],
            'prasyarat8' => ['nullable', 'max:8'],
            'prasyarat9' => ['nullable', 'max:8'],
            'prasyarat10' => ['nullable', 'max:8'],

            'prasyaratgrade' => [
                'required',
                'max:1',
            ],
        ]);


        $mk->update([
            'kodemk' => $validated['kodemk'],
            'nama' => $validated['nama'],
            'sks' => $validated['sks'],
            'nm_jenj_didik' => $validated['nm_jenj_didik'],

            'kode_kurikulum' => $validated['kode_kurikulum'],

            // JENIS PJMK
            'jenis' => $validated['jenis'],

            'prasyaratsks' => $validated['prasyaratsks'],

            'prasyarat1' => $request->filled('prasyarat1')
                ? $request->prasyarat1
                : '-',

            'prasyarat2' => $request->filled('prasyarat2')
                ? $request->prasyarat2
                : '-',

            'prasyarat3' => $request->filled('prasyarat3')
                ? $request->prasyarat3
                : '-',

            'prasyarat4' => $request->filled('prasyarat4')
                ? $request->prasyarat4
                : '-',

            'prasyarat5' => $request->filled('prasyarat5')
                ? $request->prasyarat5
                : '-',

            'prasyarat6' => $request->filled('prasyarat6')
                ? $request->prasyarat6
                : '-',

            'prasyarat7' => $request->filled('prasyarat7')
                ? $request->prasyarat7
                : '-',

            'prasyarat8' => $request->filled('prasyarat8')
                ? $request->prasyarat8
                : '-',

            'prasyarat9' => $request->filled('prasyarat9')
                ? $request->prasyarat9
                : '-',

            'prasyarat10' => $request->filled('prasyarat10')
                ? $request->prasyarat10
                : '-',

            'prasyaratgrade' => $validated['prasyaratgrade'],

            'aktif' => $request->boolean('aktif'),
        ]);


        return redirect()
            ->route('mk.index')
            ->with('success', 'Mata Kuliah berhasil diperbarui.');
    }


    /**
     * Hapus mata kuliah.
     */
    public function destroy(Mk $mk)
    {
        $mk->delete();

        return redirect()
            ->route('mk.index')
            ->with('success', 'Mata Kuliah Dihapus');
    }


    /**
     * Import mata kuliah.
     */
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xlsx,xls',
        ]);

        try {

            Excel::import(
                new MkImport,
                $request->file('file')
            );

            return redirect()
                ->route('mk.index')
                ->with('success', 'Import Berhasil!');

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {

            $failures = $e->failures();

            $errors = [];

            foreach ($failures as $failure) {
                $errors[] =
                    "Baris {$failure->row()} - {$failure->errors()[0]}";
            }

            return back()
                ->with('error', implode(', ', $errors));

        } catch (\Throwable $e) {

            return back()
                ->with('error', 'Import gagal: ' . $e->getMessage());
        }
    }
}
