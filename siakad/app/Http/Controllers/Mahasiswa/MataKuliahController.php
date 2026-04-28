<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class MataKuliahController extends Controller
{
    /**
     * Menampilkan daftar mata kuliah (halaman penawaran).
     */
    public function index()
    {
        $krsItems = $this->getDummyMataKuliah();
        return view('mahasiswa.penawaran.index', compact('krsItems'));
    }

    /**
     * Menampilkan detail mata kuliah beserta daftar mahasiswa peserta.
     */
    public function show($id)
    {
        $mataKuliah = $this->getDummyMataKuliahById($id);

        if (!$mataKuliah) {
            abort(404, 'Mata kuliah tidak ditemukan');
        }

        $pendaftar = $this->getDummyPendaftar($id);

        return view('mahasiswa.penawaran.show', compact('mataKuliah', 'pendaftar'));
    }

    /**
     * Data dummy mata kuliah.
     */
    private function getDummyMataKuliah(): array
    {
        return [
            (object) [
                'id' => 1,
                'kode_mk' => 'KM5001',
                'nama_mk' => 'KULIAH KERJA NYATA',
                'kelas' => 'A',
                'hari' => 'Sabtu',
                'jam_mulai' => '10:30:01',
                'jam_selesai' => '13:00:00',
                'sks' => 3,
                'semester' => '6',
                'periode' => 'GENAP / 2025-2026',
                'kuota' => 40,
                'keterangan' => 'Wajib diambil mahasiswa semester 6',
            ],
            (object) [
                'id' => 2,
                'kode_mk' => 'TF9705',
                'nama_mk' => 'PROPOSAL TUGAS AKHIR',
                'kelas' => 'B',
                'hari' => 'Sabtu',
                'jam_mulai' => '18:00:01',
                'jam_selesai' => '18:50:00',
                'sks' => 4,
                'semester' => '6',
                'periode' => 'GENAP / 2025-2026',
                'kuota' => 25,
                'keterangan' => 'Prasyarat: Lulus 110 SKS',
            ],
            (object) [
                'id' => 3,
                'kode_mk' => 'TF9708',
                'nama_mk' => 'MAGANG',
                'kelas' => 'C',
                'hari' => 'Sabtu',
                'jam_mulai' => '19:40:01',
                'jam_selesai' => '21:20:00',
                'sks' => 4,
                'semester' => '6',
                'periode' => 'GENAP / 2025-2026',
                'kuota' => 30,
                'keterangan' => 'Melakukan magang di perusahaan mitra',
            ],
            (object) [
                'id' => 4,
                'kode_mk' => 'TF8603',
                'nama_mk' => 'PENGOLAHAN CITRA DIGITAL',
                'kelas' => 'D',
                'hari' => 'Rabu',
                'jam_mulai' => '08:00:01',
                'jam_selesai' => '10:30:00',
                'sks' => 3,
                'semester' => '6',
                'periode' => 'GENAP / 2025-2026',
                'kuota' => 35,
                'keterangan' => 'Mata kuliah pilihan',
            ],
            (object) [
                'id' => 5,
                'kode_mk' => 'TF6604',
                'nama_mk' => 'PENGAMANAN SISTEM KOMPUTER',
                'kelas' => 'E',
                'hari' => 'Rabu',
                'jam_mulai' => '10:30:01',
                'jam_selesai' => '13:00:00',
                'sks' => 3,
                'semester' => '6',
                'periode' => 'GENAP / 2025-2026',
                'kuota' => 35,
                'keterangan' => 'Mata kuliah pilihan',
            ],
            (object) [
                'id' => 6,
                'kode_mk' => 'KM1004',
                'nama_mk' => 'PENGANTAR ENTERPRENEURSHIP',
                'kelas' => 'F',
                'hari' => 'Rabu',
                'jam_mulai' => '13:00:01',
                'jam_selesai' => '15:30:00',
                'sks' => 3,
                'semester' => '6',
                'periode' => 'GENAP / 2025-2026',
                'kuota' => 40,
                'keterangan' => 'Mata kuliah wajib universitas',
            ],
            (object) [
                'id' => 7,
                'kode_mk' => 'TF5605',
                'nama_mk' => 'E-BUSINESS',
                'kelas' => 'G',
                'hari' => 'Jumat',
                'jam_mulai' => '12:10:01',
                'jam_selesai' => '14:40:00',
                'sks' => 3,
                'semester' => '6',
                'periode' => 'GENAP / 2025-2026',
                'kuota' => 35,
                'keterangan' => 'Mata kuliah pilihan',
            ],
        ];
    }

    /**
     * Ambil satu mata kuliah berdasarkan id.
     */
    private function getDummyMataKuliahById($id)
    {
        $all = $this->getDummyMataKuliah();
        foreach ($all as $mk) {
            if ($mk->id == $id) {
                return $mk;
            }
        }
        return null;
    }

    /**
     * Data dummy daftar mahasiswa peserta.
     */
    private function getDummyPendaftar($mataKuliahId): Collection
    {
        $allMahasiswa = [
            (object) ['nrp' => '11123001', 'nama' => 'DHANIEL WIBISONO HENDRIAWAN', 'status' => 'BARU', 'tanggal_registrasi' => '18-02-2026 11:13:39'],
            (object) ['nrp' => '11123014', 'nama' => 'STEVEN JANUAR', 'status' => 'BARU', 'tanggal_registrasi' => '18-02-2026 11:32:29'],
            (object) ['nrp' => '11223010', 'nama' => 'SISKA KARTIKA SARI', 'status' => 'BARU', 'tanggal_registrasi' => '18-02-2026 11:54:11'],
            (object) ['nrp' => '11223005', 'nama' => 'ELIZABETH CLAUDIA', 'status' => 'BARU', 'tanggal_registrasi' => '18-02-2026 11:54:35'],
            (object) ['nrp' => '11123056', 'nama' => 'PRICILLIA FRANSISKA', 'status' => 'BARU', 'tanggal_registrasi' => '18-02-2026 12:00:43'],
            (object) ['nrp' => '11123041', 'nama' => 'RICARDO REIHARD WIJAYA', 'status' => 'BARU', 'tanggal_registrasi' => '18-02-2026 12:01:29'],
            (object) ['nrp' => '11123049', 'nama' => 'CHRISTIAN YOHANES', 'status' => 'BARU', 'tanggal_registrasi' => '18-02-2026 12:11:29'],
            (object) ['nrp' => '11123053', 'nama' => 'MICHELLE', 'status' => 'BARU', 'tanggal_registrasi' => '18-02-2026 12:17:55'],
            (object) ['nrp' => '11123046', 'nama' => 'FRIDS GABRIEL UMBU NGGALA LILI', 'status' => 'BARU', 'tanggal_registrasi' => '18-02-2026 12:20:36'],
            (object) ['nrp' => '11123016', 'nama' => 'APRILIA DEWI SANTOSO', 'status' => 'BARU', 'tanggal_registrasi' => '18-02-2026 12:28:29'],
            (object) ['nrp' => '11123058', 'nama' => 'FARAH APRILIA PUTRI', 'status' => 'BARU', 'tanggal_registrasi' => '18-02-2026 12:32:08'],
            (object) ['nrp' => '11123055', 'nama' => 'DEFI INGGRA AYU', 'status' => 'BARU', 'tanggal_registrasi' => '18-02-2026 12:45:49'],
            (object) ['nrp' => '11123054', 'nama' => 'ANDINA RAHMA IVA SAPUTRI', 'status' => 'BARU', 'tanggal_registrasi' => '18-02-2026 13:02:00'],
        ];

        // Bisa dimodifikasi untuk menampilkan peserta berbeda per mata kuliah
        return collect($allMahasiswa);
    }
}