<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\Penawaran;
use App\Models\Registrasi;
use App\Models\Metaperiode;
use App\Models\Periode;
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
            return redirect()->route('perwalian.index')
                ->with('error', 'Anda tidak terdaftar sebagai dosen.');
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
            return redirect()->route('perwalian.index')
                ->with('error', 'Anda tidak terdaftar sebagai dosen.');
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
            return redirect()->route('perwalian.index')
                ->with('error', 'Anda tidak terdaftar sebagai dosen.');
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

        $query = Penawaran::with(['mk.kurikulum'])
            ->whereHas('semester', function ($q) {
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
        $periodeKrs = Metaperiode::first();

        if (
            !$periodeKrs ||
            !$periodeKrs->krs_mulai ||
            !$periodeKrs->krs_selesai ||
            now()->lt($periodeKrs->krs_mulai) ||
            now()->gt($periodeKrs->krs_selesai)
        ) {
            return back()->with(
                'error',
                'Periode KRS belum dibuka atau sudah berakhir. Dosen wali tidak dapat menambahkan mata kuliah.'
            );
        }

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

        $periodeAktif = Periode::where('aktif', 1)->first();

        if (!$periodeAktif) {
            return back()->with('error', 'Tidak ada periode aktif.');
        }

        $semesterAktif = $periodeAktif->semesters()
            ->where('aktif', 1)
            ->pluck('id');

        if ($semesterAktif->isEmpty()) {
            return back()->with('error', 'Tidak ada semester aktif.');
        }

        if (!$semesterAktif->contains($penawaran->semester_id)) {
            return back()->with(
                'error',
                'Mata kuliah ini bukan bagian dari semester aktif.'
            );
        }

        $jadwalBentrok = DB::table('registrasi')
            ->join(
                'penawaran',
                'registrasi.penawaran_id',
                '=',
                'penawaran.recno'
            )
            ->join(
                'semester',
                'penawaran.semester_id',
                '=',
                'semester.id'
            )
            ->join(
                'periode',
                'semester.periode_id',
                '=',
                'periode.id'
            )
            ->where('registrasi.nrp', $mahasiswa->nrp)
            ->where('periode.id', $periodeAktif->id)
            ->whereIn('semester.id', $semesterAktif)
            ->where('penawaran.hari', $penawaran->hari)
            ->where(
                'penawaran.mulaipukul',
                '<',
                $penawaran->selesaipukul
            )
            ->where(
                'penawaran.selesaipukul',
                '>',
                $penawaran->mulaipukul
            )
            ->exists();

        if ($jadwalBentrok) {
            return back()->with(
                'error',
                'Pendaftaran gagal! Jadwal mata kuliah bentrok dengan mata kuliah yang sudah diambil.'
            );
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

        $periodeKrs = Metaperiode::first();

        if (
            !$periodeKrs ||
            !$periodeKrs->krs_mulai ||
            !$periodeKrs->krs_selesai ||
            now()->lt($periodeKrs->krs_mulai) ||
            now()->gt($periodeKrs->krs_selesai)
        ) {
            return back()->with(
                'error',
                'Periode KRS belum dibuka atau sudah berakhir. Dosen wali tidak dapat menghapus mata kuliah.'
            );
        }

        Registrasi::where('nrp', $mahasiswa->nrp)
            ->where('penawaran_id', $penawaran->recno)
            ->delete();

        return back()->with('success', 'Mata kuliah berhasil dibatalkan.');
    }
}