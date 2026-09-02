<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Imports\KeuanganImport;
use App\Exports\KeuanganExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel as FacadesExcel;


class KeuanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;

        $mahasiswas = Mahasiswa::with(['dosenWali', 'programStudi'])
            ->when($search, function ($query) use ($search) {$query->where('nrp', 'like', '%' . $search . '%');})
            ->paginate(10)
            ->withQueryString();

        return view('keuangan.mahasiswas.index', [
            'mahasiswas' => $mahasiswas,
            'search' => $search,
        ]);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xlsx,xls'
        ]);

        try {

            FacadesExcel::import(
                new KeuanganImport,
                $request->file('file')
            );

            return redirect()
                ->route('keuangan.mahasiswa.index')
                ->with('success', 'Import data keuangan berhasil.');

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {

            $failures = $e->failures();

            $errors = [];

            foreach ($failures as $failure) {
                $errors[] =
                    "Baris {$failure->row()} - {$failure->errors()[0]}";
            }

            return back()->with(
                'error',
                implode(', ', $errors)
            );

        } catch (\Throwable $e) {

            return back()->with(
                'error', 'Import gagal. Periksa kembali file yang diupload.'
            );
        }
    }

    public function export()
    {
        return FacadesExcel::download(
            new KeuanganExport,
            'template_import_keuangan.xlsx'
        );
    }

    public function blokir(Mahasiswa $mahasiswa)
    {
        $mahasiswa->update(['status_blokir' => 'BLOKIR']);

        return redirect()->route('keuangan.mahasiswa.index')->with('success', 'Mahasiswa berhasil diblokir.');
    }

    /**
     * Display the specified resource.
     */
    public function bukablokir(Mahasiswa $mahasiswa)
    {
        $mahasiswa->update(['status_blokir' => 'BELUM_KRS']);

        return redirect()->route('keuangan.mahasiswa.index')->with('success', 'Mahasiswa berhasil dibuka blokir.');
    }
 

    /**
     * Show the form for editing the specified resource.
     */

}
