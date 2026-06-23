<x-layout title="Informasi Mata Kuliah">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Informasi Mata Kuliah</h1>

        <!-- Informasi Detail Mata Kuliah + Tombol Aksi -->
        <div class="mb-6 p-4 bg-base-100 rounded-lg shadow">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div><strong>Kode MK:</strong> {{ $mataKuliah->kode_mk }}</div>
                <div><strong>Mata Kuliah:</strong> {{ $mataKuliah->nama_mk }}</div>
                <div><strong>Dosen:</strong> {{ $mataKuliah->dosen ?? '-' }}</div>
                <div><strong>Hari:</strong> {{ $mataKuliah->hari }}</div>
                <div><strong>Jam Mulai:</strong> {{ $mataKuliah->jam_mulai }}</div>
                <div><strong>Jam Selesai:</strong> {{ $mataKuliah->jam_selesai }}</div>
                <div><strong>SKS:</strong> {{ $mataKuliah->sks }}</div>
                <div><strong>Semester:</strong> {{ $mataKuliah->semester }}</div>
                <div><strong>Keterangan :</strong> {{ $mataKuliah->keterangan ?? '-' }}</div>
                <div><strong>Periode :</strong> {{ $mataKuliah->periode ?? 'GENAP / 2025-2026' }}</div>
                <div>
                    <strong>Aksi Anda :</strong>
                    @php
                        $nrpMahasiswa = session('nrp') ?? (Auth::check() ? Auth::user()->username : null);
                        $sudahTerdaftar = $pendaftar->contains('nrp', $nrpMahasiswa);
                    @endphp

                    @if($nrpMahasiswa)
                        @if($statusBlokir === 'BELUM_KRS')
                            @if($sudahTerdaftar)
                                <!-- Tombol Batal -->
                                <form action="{{ route('mahasiswa.krs.destroy', ['id' => $mataKuliah->id_registrasi]) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan pendaftaran mata kuliah ini?')" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md shadow ml-2">
                                        Batal
                                    </button>
                                </form>
                            @else
                                <!-- Tombol Daftar -->
                                <form action="{{ route('mahasiswa.krs.store') }}" method="POST" style="display:inline;">
                                    @csrf
                                    <input type="hidden" name="penawaran_id" value="{{ $mataKuliah->penawaran_id ?? $mataKuliah->id }}">
                                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md shadow ml-2">
                                        Daftar
                                    </button>
                                </form>
                            @endif
                        @else
                            <span class="text-gray-500 ml-2">Status KRS: {{ $statusBlokir }} – Tidak dapat melakukan perubahan.</span>
                        @endif
                    @else
                        <span class="text-gray-500 ml-2">(Login untuk mendaftar)</span>
                    @endif
                </div>
            </div>
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
                        <tr>
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

        <!-- Tombol Kembali -->
        <div class="mt-6">
            <a href="{{ url()->previous() }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md shadow">
                ← Kembali
            </a>
        </div>
    </div>
</x-layout>