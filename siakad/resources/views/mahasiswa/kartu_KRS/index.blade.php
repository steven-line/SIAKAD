<x-layout title="KRS UWIKA">
    <div class="container mx-auto p-4">
        <!-- Header -->
        <h1 class="text-2xl font-bold mb-2 text-white">KRS Anda yang Terdaftar</h1>
        <p class="mb-2 text-white">Berikut adalah daftar mata kuliah yang sudah anda daftarkan. Centang mata kuliah yang ingin dibatalkan, lalu klik tombol "Batalkan yang Dipilih".</p>

        <!-- Peringatan -->
        <div class="alert alert-warning mb-4 p-3 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700">
            <strong>Ingat!</strong> Sebelum membatalkan, diskusikan dengan 
            <a href="#" class="text-blue-600 underline mx-1">Dosen Wali</a> anda.
        </div>

        <!-- Form untuk pembatalan KRS -->
        <form action="{{ route('mahasiswa.krs.batal') }}" method="POST" id="formBatalKrs">
            @csrf
            @method('DELETE')

            <!-- Status Validasi dan Cetak KRS -->
            <div class="flex flex-wrap justify-between items-center mt-6 p-4 bg-gray-100 rounded-lg">
                <div class="flex items-center space-x-2">
                    <span class="text-green-700 font-semibold">Status:</span>
                    <span class="bg-green-600 text-white px-3 py-1 rounded-full text-sm">
                        {{ $statusBlokir ?? 'KRS Anda Telah Tervalidasi' }}
                    </span>
                </div>
                <div class="flex gap-2">
                    <button type="button" id="cetakKRS" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md shadow">
                        Cetak KRS
                    </button>
                </div>
            </div>

            <!-- Tabel KRS dengan checkbox pembatalan -->
            <div class="overflow-x-auto rounded-box border border-base-content/5 bg-white shadow-md mt-4">
                <table class="table w-full">
                    <thead class="bg-blue-500 text-white">
                        <tr>
                            <th class="px-4 py-2">No</th>
                            <th class="px-4 py-2">Kode</th>
                            <th class="px-4 py-2">Mata Kuliah</th>
                            <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2">Jadwal (WIB)</th>
                            <th class="px-4 py-2">SKS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($krsItems ?? [] as $index => $item)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-2 text-black">{{ $index + 1 }}</td>
                            <td class="px-4 py-2 text-black">
                                <a href="{{ route('mata-kuliah.show', $item->kode_mk) }}">
                                    {{ $item->kode_mk }}
                                </a>
                            </td>
                            <td class="px-4 py-2 text-black">
                                <a href="{{ route('mata-kuliah.show', $item->kode_mk) }}">
                                    {{ $item->nama_mk }}
                                </a>
                            </td>
                            <td class="px-4 py-2">
                                <span class="bg-green-500 text-white px-2 py-1 rounded text-sm">{{ $item->status }}</span>
                            </td>
                            <td class="px-4 py-2 text-black">
                                <a href="{{ route('mata-kuliah.show', $item->kode_mk) }}">
                                    {{ $item->hari }}, {{ $item->jam_mulai }}-{{ $item->jam_selesai }}
                                </a>
                            </td>
                            <td class="px-4 py-2 text-black text-center">
                                <a href="{{ route('mata-kuliah.show', $item->kode_mk) }}">
                                    {{ $item->sks }}
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">Belum ada mata kuliah yang dipilih.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>

        <!-- Total SKS -->
        <div class="flex justify-end mt-4 font-bold text-lg">
            TOTAL {{ $totalSks }} SKS
        </div>

        <!-- Informasi Tambahan -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6 p-4 bg-white border rounded-lg shadow-sm">
            <div class="text-center">
                <p class="text-blue-500 text-sm">Nilai IPS terakhir</p>
                <p class="font-bold text-lg text-blue-600">{{ $ipsTerakhir }}</p>
            </div>
            <div class="text-center">
                <p class="text-blue-500 text-sm">Limit SKS anda</p>
                <p class="font-bold text-lg text-blue-600">{{ $limitSks }} SKS</p>
            </div>
            <div class="text-center">
                <p class="text-blue-500 text-sm">Toleransi SKS anda</p>
                <p class="font-bold text-lg text-blue-600">{{ $toleransiSks }} SKS</p>
            </div>
            <div class="text-center">
                <p class="text-blue-500 text-sm">Sisa Limit SKS anda</p>
                <p class="font-bold text-lg text-blue-600">{{ $sisaLimit }} SKS</p>
            </div>
        </div>
    </div>

    <!-- JavaScript untuk check/uncheck semua -->
    <script>
        document.getElementById('pilihSemua')?.addEventListener('change', function(e) {
            document.querySelectorAll('.checkboxBatal').forEach(cb => cb.checked = e.target.checked);
        });

        document.getElementById('cetakKRS')?.addEventListener('click', function() {
            window.print();
        });
    </script>
</x-layout>