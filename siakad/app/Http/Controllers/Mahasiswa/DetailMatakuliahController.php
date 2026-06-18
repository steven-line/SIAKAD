<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Penawaran;
use App\Models\Registrasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DetailMataKuliahController extends Controller
{
    /**
     * Menampilkan detail mata kuliah berdasarkan kode MK
     */
    public function show($kode_mk)
    {
        // Ambil data penawaran + relasi mk
        $penawaran = Penawaran::with('mk')->where('kodemk', $kode_mk)->first();

        if (!$penawaran) {
            abort(404, 'Mata kuliah tidak ditemukan');
        }

        // Cek akses berdasarkan pataum
        $pataumUser = session('pataum') ?? (Auth::check() ? substr(Auth::user()->pataum, 0, 1) : null);
        if ($pataumUser && $penawaran->pataum !== $pataumUser) {
            abort(403, 'Anda tidak memiliki akses ke mata kuliah ini.');
        }

        // Ambil NRP mahasiswa yang sedang login
        $nrpMahasiswa = session('nrp') ?? (Auth::check() ? Auth::user()->username : null);
        
        // Cari apakah mahasiswa sudah terdaftar pada mata kuliah ini
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

        // Susun objek mataKuliah
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

        // Ambil daftar mahasiswa yang sudah registrasi
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

        return view('mahasiswa.penawaran.show', compact('mataKuliah', 'pendaftar'));
    }
}