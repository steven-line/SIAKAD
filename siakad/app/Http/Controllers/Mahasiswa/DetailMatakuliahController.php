<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Penawaran;
use App\Models\Registrasi;
use App\Models\Mahasiswa;
use App\Models\Metaperiode;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DetailMataKuliahController extends Controller
{
    public function show(Penawaran $penawaran)
    {
        $registrasis = Registrasi::where('penawaran_id', $penawaran->recno)->get();
        $sudahAmbil = Registrasi::where('nrp', Auth::user()->mahasiswa->nrp)
            ->where('penawaran_id', $penawaran->recno)
            ->exists();
        
        $periodeKrs = Metaperiode::first();
        $statusBlokir = Auth::user()->mahasiswa->status_blokir;
      
        return view('mahasiswa.penawaran.show', compact('registrasis', 'penawaran', 'sudahAmbil', 'statusBlokir','periodeKrs'));
    }

    public function daftar(Penawaran $penawaran)
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;
       
        $periodeKrs = Metaperiode::first();
        if (!$mahasiswa) {
            return back()->with('error', 'Data mahasiswa tidak ditemukan.');
        }
        if (now()->lt($periodeKrs->krs_mulai) || now()->gt($periodeKrs->krs_selesai)) {
            return redirect()->back()->with('error', 'Pendaftaran gagal! Anda berada di luar periode KRS.');
        }
        if ($mahasiswa->status_blokir === 'TERKUNCI') {
            return back()->with('error', 'KRS Anda terkunci. Tidak dapat mengambil mata kuliah.');
        }

        $sudah = Registrasi::where('nrp', $mahasiswa->nrp)
            ->where('penawaran_id', $penawaran->recno)
            ->exists();

        if ($sudah) {
            return back()->with('error', 'Sudah mengambil mata kuliah ini.');
        }

        // 1. MULAI TRANSAKSI DATABASE
        DB::beginTransaction();

        try {
            // Data dibuat di dalam lingkup transaksi (belum permanen)
            Registrasi::create([
                'nrp' => $mahasiswa->nrp,
                'penawaran_id' => $penawaran->recno,
                'status' => 'B',
                'tanggal' => now()->toDateString(),
                'jam' => now()->toTimeString(),
            ]);

            $registrasiMK = DB::table('registrasi')
                ->join('penawaran', 'registrasi.penawaran_id', '=', 'penawaran.recno')
                ->join('semester', 'penawaran.semester_id', '=', 'semester.id')
                ->join('mk' ,'penawaran.kodemk', '=', 'mk.kodemk')
                ->join('periode', 'semester.periode_id', '=', 'periode.id')
                ->where('periode.aktif', '=', 1)
                ->where('registrasi.nrp', $mahasiswa->nrp)
                ->select('mk.sks')
                ->get();
     
            // 2. JIKA SKS MELEBIHI LIMIT, BATALKAN (ROLLBACK)
            if ($registrasiMK->sum('sks') > $mahasiswa->ips->sks) {
                DB::rollBack(); // Data Registrasi::create tadi otomatis dihapus kembali
                return back()->withErrors(['limit_sks' => 'Pendaftaran gagal! Total SKS melampaui limit Anda.']);
            }

            // 3. JIKA AMAN, SIMPAN PERMANEN
            DB::commit();

            return redirect()
                ->route('mahasiswa.krs.index')
                ->with('success', 'Berhasil mengambil KRS.');

        } catch (\Exception $e) {
            // 4. ROLLBACK JIKA TERJADI ERROR SISTEM
            DB::rollBack();
            Log::error('Gagal daftar KRS: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan sistem. Silakan coba lagi.');
        }
    }

    public function batal(Penawaran $penawaran)
    {
        $mahasiswa = auth()->user()->mahasiswa;

        if (!$mahasiswa) {
            return back()->with('error', 'Data mahasiswa tidak ditemukan.');
        }

        if ($mahasiswa->status_blokir === 'TERKUNCI') {
            return back()->with('error', 'KRS Anda terkunci.');
        }

        Registrasi::where('nrp', $mahasiswa->nrp)
            ->where('penawaran_id', $penawaran->recno)
            ->delete();

        return back()->with('success', 'Berhasil membatalkan KRS.');
    }
}
