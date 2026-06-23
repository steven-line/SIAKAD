<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Penawaran;
use App\Models\Registrasi;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DetailMataKuliahController extends Controller
{
    public function show($kode_mk)
    {
        // ============================================================
        // 1. DAPATKAN PATAUM USER
        // ============================================================
        $pataumUser = session('pataum');

        if (!$pataumUser && Auth::check()) {
            $user = Auth::user();
            if ($user && isset($user->pataum)) {
                $pataumUser = substr($user->pataum, 0, 1);
                session(['pataum' => $pataumUser]);
            }
        }

        // ============================================================
        // 2. CARI PENAWARAN YANG COCOK DENGAN PATAUM USER
        // ============================================================
        $query = Penawaran::with('mk')->where('kodemk', $kode_mk);

        if ($pataumUser) {
            $penawaran = $query->where('pataum', $pataumUser)->first();

            if (!$penawaran) {
                $penawaran = Penawaran::with('mk')
                    ->where('kodemk', $kode_mk)
                    ->whereNull('pataum')
                    ->first();
            }
        } else {
            $penawaran = $query->first();
        }

        if (!$penawaran) {
            abort(404, 'Mata kuliah tidak ditemukan untuk kelas Anda.');
        }

        // ============================================================
        // 3. CEK AKSES (KEAMANAN)
        // ============================================================
        if ($penawaran->pataum && $pataumUser && $penawaran->pataum !== $pataumUser) {
            abort(403, 'Anda tidak memiliki akses ke mata kuliah ini.');
        }

        // ============================================================
        // 4. AMBIL NRP DAN STATUS BLOKIR MAHASISWA
        // ============================================================
        $nrpMahasiswa = session('nrp') ?? (Auth::check() ? Auth::user()->username : null);

        $statusBlokir = 'BELUM_KRS'; // default
        if ($nrpMahasiswa) {
            $mahasiswa = Mahasiswa::where('nrp', $nrpMahasiswa)->first();
            if ($mahasiswa) {
                $statusBlokir = $mahasiswa->status_blokir;
            }
        }

        // ============================================================
        // 5. CEK REGISTRASI MAHASISWA UNTUK MATA KULIAH INI
        // ============================================================
        $id_registrasi = null;
        if ($nrpMahasiswa) {
            $registrasi = Registrasi::where('nrp', $nrpMahasiswa)
                ->where('kodemk', $penawaran->kodemk)
                ->where('periode', $penawaran->periode)
                ->first();
            if ($registrasi) {
                $id_registrasi = $registrasi->regkrs;
            }
        }

        // ============================================================
        // 6. SUSUN OBJEK MATA KULIAH
        // ============================================================
        $mataKuliah = (object) [
            'kode_mk'       => $penawaran->kodemk,
            'nama_mk'       => $penawaran->mk ? $penawaran->mk->nama : '-',
            'dosen'         => $penawaran->dosen ?? '-',
            'kelas'         => $penawaran->sesi ?? 'A',
            'hari'          => $penawaran->hari,
            'jam_mulai'     => $penawaran->mulaipukul ? date('H:i:s', strtotime($penawaran->mulaipukul)) : '',
            'jam_selesai'   => $penawaran->selesaipukul ? date('H:i:s', strtotime($penawaran->selesaipukul)) : '',
            'sks'           => $penawaran->mk ? $penawaran->mk->sks : 0,
            'semester'      => $penawaran->semester ?? '6',
            'periode'       => $penawaran->periode ?? 'GENAP / 2025-2026',
            'kuota'         => $penawaran->pagu ?? '-',
            'keterangan'    => $penawaran->keterangan ?? '-',
            'penawaran_id'  => $penawaran->recno,
            'id_registrasi' => $id_registrasi,
        ];

        // ============================================================
        // 7. AMBIL DAFTAR PESERTA
        // ============================================================
        $pendaftar = Registrasi::with('mahasiswa')
            ->where('kodemk', $penawaran->kodemk)
            ->where('periode', $penawaran->periode)
            ->get()
            ->map(function ($reg) {
                return (object) [
                    'nrp'                => $reg->nrp,
                    'nama'               => $reg->mahasiswa ? $reg->mahasiswa->nama : '-',
                    'status'             => $reg->status,
                    'tanggal_registrasi' => $reg->tanggal ? $reg->tanggal->format('d-m-Y') : '-',
                ];
            });

        return view('mahasiswa.penawaran.show', compact('mataKuliah', 'pendaftar', 'statusBlokir'));
    }
}