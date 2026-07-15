<x-layout title="KRS UWIKA">
    @if($statusBlokir === 'BLOKIR')
        <div role="alert" class="alert alert-error mb-6">
            <span>
                KRS anda terblokir, mohon hubungi bagian keuangan untuk menyelesaikan tunggakan.
            </span>
        </div>

    @else

        @if($statusBlokir === 'TERKUNCI')
            <div role="alert" class="alert alert-warning mb-6">
                <span>
                    KRS Anda sedang terkunci. Anda masih dapat melihat data, tetapi tidak dapat melakukan perubahan.
                </span>
            </div>
        @endif

    {{-- ✅ TERKUNCI / NORMAL → BOLEH LIHAT --}}
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-2">Hasil KHS Anda</h1>
        <p class="mb-4">Dibawah ini Nilai KHS [Transkrip Nilai] Anda yang telah anda tempuh selama ini</p>

        <!-- Info Mahasiswa -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mb-6 p-4 bg-transparent rounded">
            <div><strong>Periode :</strong> {{ $periode_aktif ?? '-' }}</div>
            <div><strong>NRP :</strong> {{ $mahasiswa->nrp ?? '-' }}</div>
            <div><strong>Semester :</strong> {{ $semester_aktif ?? '-' }}</div>
            <div><strong>Nama :</strong> {{ $mahasiswa->nama ?? '-' }}</div>
            <div><strong>Program Studi :</strong> {{ $mahasiswa->prodi ?? '-' }}</div>
            <div><strong>Dosen Wali :</strong> {{ $dosenWali ?? '-' }}</div>
        </div>

        @forelse ($results as $semester)
        <div class="mb-8">
            <h2 class="text-xl font-semibold mb-2">Periode: {{ $semester->periode }}</h2>

            <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100">
                <table class="table">
                    <thead class="bg-blue-500 text-white">
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Mata Kuliah</th>
                            <th>SKS</th>
                            <th>Grade</th>
                            <th>Mutu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($semester->items as $index => $row)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $row->kode }}</td>
                            <td>{{ $row->nama_mk ?? '-' }}</td>
                            <td>{{ $row->sks ?? '-' }}</td>
                            <td class="font-semibold">{{ $row->na ?? '-' }}</td>
                            <td>{{ number_format($row->mutu, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-2 text-sm font-semibold">
                <span class="mr-4">Nilai IPS : {{ number_format($semester->ips, 3) }}</span>
                <span class="mr-4">TOTAL : {{ $semester->total_sks }}</span>
                <span>{{ number_format($semester->total_mutu, 1) }}</span>
            </div>

            <div class="mt-1 text-sm">
                SKS Maksimum yang dapat diambil Semester Depan : {{ $semester->max_sks }}
            </div>

            <div class="mt-1 text-md font-semibold">
                Grade Nilai : A = 80-100 | AB = 74-79 | B = 68-73 | BC = 62-67 | C = 56-61 | D = 41-55 | E = 0-40
            </div>
        </div>
        @empty
            <div class="text-center py-4">Belum ada data KHS.</div>
        @endforelse

        <div class="mt-6 p-4 bg-transparent rounded">
            <p><strong>Total SKS yang sudah anda Tempuh :</strong> {{ $total_sks_tempuh ?? 0 }} SKS</p>
            <p><strong>Nilai IPK :</strong> {{ number_format($ipk ?? 0, 3) }}</p>
        </div>
    </div>

    @endif

</x-layout>