<x-layout title="Transkrip Nilai">
    @if($statusBlokir == 'TERKUNCI')
    <div role="alert" class="alert alert-error">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span>KRS anda terkunci, mohon hubungi bagian keuangan untuk menyelesaikan tunggakan. </span>
        </div>
    @else
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Transkrip Nilai</h1>

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
                        <td>{{ $row->na ?? '-' }}</td>
                        <td>{{ number_format($row->mutu, 2) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">Belum ada data transkrip.</td>
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
    @endif
</x-layout>