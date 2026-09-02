<?php

namespace App\Http\Controllers;

use App\Exports\NilaiTransferExport;
use App\Http\Controllers\Controller;
use App\Imports\NilaiTransferImport;
use App\Models\KrsTransfer;
use App\Models\Mahasiswa;
use App\Models\NilaiTransfer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class MahasiswaTransferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search'); 
        $mahasiswas = Mahasiswa::when($search, function($query, $search) {
            $query->where('nrp', 'like', '%' . $search . '%')->orWhereHas('biodata', function (Builder $query) use ($search) {
                $query->where('nama', 'like', '%' . $search . '%');
            });
            
           
        })->where('transfer', true)->with('dosenWali')->paginate(10);

        return view('admin.mahasiswa_transfer.index', [
            'mahasiswas' => $mahasiswas,
            'search' => $search,
        ]);
    }
    public function export() {
        return Excel::download(new NilaiTransferExport, 'nilai_transfer.xlsx');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function upload(Request $request) {
           $request->validate([
            'file' => 'nullable|mimes:csv,xlsx,xls'
        ]);

        try {
            // Proses imports
            Excel::import(new NilaiTransferImport, $request->file('file'));

            // Jika berhasil
            return redirect()
                ->route('mahasiswa_transfer.index')
                ->with('success', 'Import berhasil.');
                
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            // Ambil error validasi dari Excel
            $failures = $e->failures();

            $errors = [];
            foreach ($failures as $failure) {
                $errors[] = "Baris {$failure->row()} - {$failure->errors()[0]}";
            }

            return back()->with('error', implode(', ', $errors));

        } catch (\Throwable $e) {
            // Error umum
            return back()->with('error', 'Import gagal: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Mahasiswa $mahasiswa)
    {
        $nilaiTransfer = NilaiTransfer::where('nrp', $mahasiswa->nrp)->get();

        return view('admin.mahasiswa_transfer.show', compact('nilaiTransfer'));
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
