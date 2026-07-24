<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\Penawaran;
use App\Models\Registrasi;
use App\Models\Metaperiode;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PerwalianController extends Controller
{
    public function index()
    {
        $user = auth()->user();

       

        $nimDosen = $user->dosen;

        $mahasiswas = Mahasiswa::with('dosenWali')
            ->where('dosen_wali', $nimDosen->nim_dosen)
            ->get();

        return view('dosen_wali.perwalian.index', ['mahasiswas' => $mahasiswas]);
    }

    public function show(Mahasiswa $mahasiswa)
    {
        $user = auth()->user();

        if (!$user || !$user->dosen) {
            return redirect()->route('perwalian.index')->with('error', 'Anda tidak terdaftar sebagai dosen.');
        }

        if ($mahasiswa->dosen_wali !== $user->dosen->nim_dosen) {
            abort(403, 'Anda tidak memiliki akses ke mahasiswa ini.');
        }

        return view('dosen_wali.perwalian.show', ['mahasiswa' => $mahasiswa]);
    }

    public function validasi(Mahasiswa $mahasiswa)
    {
        $user = auth()->user();

        if (!$user || !$user->dosen) {
            return redirect()->route('perwalian.index')->with('error', 'Anda tidak terdaftar sebagai dosen.');
        }

        if ($mahasiswa->dosen_wali !== $user->dosen->nim_dosen) {
            abort(403, 'Anda tidak memiliki akses ke mahasiswa ini.');
        }

        $mahasiswa->status_blokir = "DISETUJUI";
        $mahasiswa->save();

        return redirect()->route('perwalian.index')
            ->with('success', 'Mahasiswa berhasil divalidasi');
    }

    public function lock(Mahasiswa $mahasiswa)
    {
        $user = auth()->user();

        if (!$user || !$user->dosen) {
            return redirect()->route('perwalian.index')->with('error', 'Anda tidak terdaftar sebagai dosen.');
        }

        if ($mahasiswa->dosen_wali !== $user->dosen->nim_dosen) {
            abort(403, 'Anda tidak memiliki akses ke mahasiswa ini.');
        }

        $mahasiswa->status_blokir = "TERKUNCI";
        $mahasiswa->save();

        return redirect()->route('perwalian.index')
            ->with('success', 'KRS TERKUNCI');
    }

    public function unlock(Mahasiswa $mahasiswa)
    {
        $user = auth()->user();

        if (!$user || !$user->dosen) {
            return redirect()->route('perwalian.index')
                ->with('error', 'Anda tidak terdaftar sebagai dosen.');
        }

        if ($mahasiswa->dosen_wali !== $user->dosen->nim_dosen) {
            abort(403, 'Anda tidak memiliki akses ke mahasiswa ini.');
        }

        $mahasiswa->status_blokir = "BELUM_KRS";
        $mahasiswa->save();

        return redirect()->route('perwalian.index')
            ->with('success', 'Kunci KRS berhasil dibuka. Mahasiswa dapat mengisi KRS kembali.');
    }

        public function penawaran($nrp)
    {
        $mahasiswa = Mahasiswa::findOrFail($nrp);

        $prodi = $mahasiswa?->prodi;

        $query = Penawaran::with(['mk.kurikulum'])->whereHas('semester', function ($q){

                $q->where('aktif', 1);
            })
            ->whereHas('mk.kurikulum', function ($q) use ($prodi) {
                $q->where('kode_prodi', $prodi);
            });

        $penawaran = $query->get();
        return view(
            'dosen_wali.perwalian.penawaran_mahasiswa',
            compact('mahasiswa', 'penawaran')
        );
    }

    public function showPenawaran($nrp, Penawaran $penawaran)
    {
        $mahasiswa = Mahasiswa::findOrFail($nrp);

        // Pastikan mahasiswa memang anak bimbingan dosen yang login
        if ($mahasiswa->dosen_wali !== auth()->user()->dosen->nim_dosen) {
            abort(403);
        }

        $registrasis = Registrasi::where('penawaran_id', $penawaran->recno)->get();

        $sudahAmbil = Registrasi::where('nrp', $mahasiswa->nrp)
            ->where('penawaran_id', $penawaran->recno)
            ->exists();

        return view(
            'dosen_wali.perwalian.detail_penawaran',
            compact(
                'mahasiswa',
                'penawaran',
                'registrasis',
                'sudahAmbil'
            )
        );
    }

    public function ambilKrs($nrp, Penawaran $penawaran)
    {
        $mahasiswa = Mahasiswa::findOrFail($nrp);

        if ($mahasiswa->dosen_wali !== auth()->user()->dosen->nim_dosen) {
            abort(403);
        }

        $cek = Registrasi::where('nrp', $mahasiswa->nrp)
            ->where('penawaran_id', $penawaran->recno)
            ->exists();

        if ($cek) {
            return back()->with('error', 'Mata kuliah sudah diambil.');
        }

        Registrasi::create([
            'nrp'          => $mahasiswa->nrp,
            'penawaran_id' => $penawaran->recno,
            'kode'         => $penawaran->kodemk,
            'status'       => 'B',
            'tanggal'      => Carbon::now(),
            'sks'          => $penawaran->mk->sks,
            'hari'         => $penawaran->hari,
            'mulaipukul'   => $penawaran->mulaipukul,
            'selesaipukul' => $penawaran->selesaipukul,
        ]);

        return back()->with('success', 'Mata kuliah berhasil ditambahkan.');
    }

    public function batalKrs($nrp, Penawaran $penawaran)
    {
        $mahasiswa = Mahasiswa::findOrFail($nrp);

        if ($mahasiswa->dosen_wali !== auth()->user()->dosen->nim_dosen) {
            abort(403);
        }

        Registrasi::where('nrp', $mahasiswa->nrp)
            ->where('penawaran_id', $penawaran->recno)
            ->delete();

        return back()->with('success', 'Mata kuliah berhasil dibatalkan.');
    }

}