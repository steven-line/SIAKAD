<x-layout title="Informasi Mata Kuliah">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Informasi Mata Kuliah</h1>

        <!-- Informasi Detail Mata Kuliah -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6 p-4 bg-gray-100 rounded-lg">
            <div><strong>Kode MK:</strong> {{ $mataKuliah->kode_mk }}</div>
            <div><strong>Nama MK:</strong> {{ $mataKuliah->nama_mk }}</div>
            <div><strong>Kelas:</strong> {{ $mataKuliah->kelas }}</div>
            <div><strong>Hari:</strong> {{ $mataKuliah->hari }}</div>
            <div><strong>Jam Mulai:</strong> {{ $mataKuliah->jam_mulai }}</div>
            <div><strong>Jam Selesai:</strong> {{ $mataKuliah->jam_selesai }}</div>
            <div><strong>SKS:</strong> {{ $mataKuliah->sks }}</div>
            <div><strong>Semester:</strong> {{ $mataKuliah->semester }}</div>
        </div>

        <!-- Info Semester/SKS, Periode, Kuota, Keterangan -->
        <div class="mb-6 p-4 border rounded-lg bg-blue-100 shadow-sm">
            <p><strong>Semester / SKS :</strong> {{ $mataKuliah->semester }} / {{ $mataKuliah->sks }} SKS</p>
            <p><strong>Periode :</strong> {{ $mataKuliah->periode ?? 'GENAP / 2025-2026' }}</p>
            <p><strong>Kuota Kelas :</strong> {{ $mataKuliah->kuota ?? '-' }}</p>
            <p><strong>Keterangan :</strong> {{ $mataKuliah->keterangan ?? '-' }}</p>
        </div>

        <!-- Tabel Daftar Mahasiswa -->
        <h2 class="text-xl font-semibold mb-2">Daftar Mahasiswa Peserta</h2>
        <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100">
            <table class="table w-full">
                <thead class="bg-blue-500 text-white">
                    <tr>
                        <th class="px-4 py-2">No</th>
                        <th class="px-4 py-2">NRP</th>
                        <th class="px-4 py-2">Nama</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Tanggal Registrasi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pendaftar as $index => $mhs)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $index + 1 }}</td>
                            <td class="px-4 py-2">{{ $mhs->nrp }}</td>
                            <td class="px-4 py-2">{{ $mhs->nama }}</td>
                            <td class="px-4 py-2">{{ $mhs->status }}</td>
                            <td class="px-4 py-2">{{ $mhs->tanggal_registrasi }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center px-4 py-2">Belum ada mahasiswa terdaftar</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Tombol Kembali (opsional) -->
        <div class="mt-6">
            <a href="{{ url()->previous() }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md shadow">
                ← Kembali
            </a>
        </div>
    </div>
</x-layout>