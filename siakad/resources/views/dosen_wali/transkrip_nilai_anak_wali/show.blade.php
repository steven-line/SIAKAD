<x-layout title="Transkrip Nilai">
    <div>
        <a class="join-item btn btn-primary mb-10" href="{{ route('nilai_khs_anak_wali.index') }}">
            ⮜ Previous page
        </a>
    </div>

    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Transkrip Nilai Mahasiswa</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mb-6 p-4 bg-transparent rounded">
            <div><strong>NRP :</strong> {{ $mahasiswa->nrp ?? '-' }}</div>
            <div><strong>Nama :</strong> {{ $biodata->nama ?? '-' }}</div>
            <div><strong>Program Studi :</strong> {{ $mahasiswa->prodi ?? '-' }}</div>
            <div><strong>Dosen Wali :</strong> {{ $dosenWali ?? '-' }}</div>
        </div>

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
                    @forelse ($transkripWithMutu as $index => $row)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $row->kode }}</td>
                            <td>{{ $row->nama_mk ?? '-' }}</td>
                            <td>{{ $row->sks ?? '-' }}</td>
                            <td class="font-semibold">{{ $row->na ?? '-' }}</td>
                            <td>{{ number_format($row->mutu, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">Belum ada data transkrip.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4 p-4 bg-transparent rounded">
            <p><strong>Total SKS:</strong> {{ $total_sks ?? 0 }}</p>
            <p><strong>Total Mutu:</strong> {{ number_format($total_mutu ?? 0, 2) }}</p>
            <p><strong>IPK:</strong> {{ number_format($ipk ?? 0, 3) }}</p>
        </div>
    </div>
</x-layout>