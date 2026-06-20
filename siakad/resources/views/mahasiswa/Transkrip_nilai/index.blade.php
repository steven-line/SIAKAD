<x-layout title="Transkrip Nilai">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Transkrip Nilai</h1>

        <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100">
            <table class="table">
                <thead class="bg-blue-500 text-white">
                    <tr>
                        <th>No</th>
                        <th>Periode</th>
                        <th>Kode</th>
                        <th>Mata Kuliah</th>
                        <th>SKS</th>
                        <th>Nilai</th>
                        <th>UTS</th>
                        <th>UAS</th>
                        <th>TTT1</th>
                        <th>TTT2</th>
                        <th>Lain</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transkrip as $index => $row)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $row->periode }}</td>
                        <td>{{ $row->kode }}</td>
                        <td>{{ $row->nama_mk ?? '-' }}</td>
                        <td>{{ $row->sks ?? '-' }}</td>
                        <td class="text-center">
                            @if($row->bu == '1')
                                <span class="badge bg-green-500 text-white px-2 py-1 rounded">{{ $row->na ?? 'L' }}</span>
                            @elseif($row->bu == '0')
                                <span class="badge bg-red-500 text-white px-2 py-1 rounded">{{ $row->na ?? 'E' }}</span>
                            @else
                                <span>-</span>
                            @endif
                        </td>
                        <td>{{ $row->uts ?? '-' }}</td>
                        <td>{{ $row->uas ?? '-' }}</td>
                        <td>{{ $row->ttt1 ?? '-' }}</td>
                        <td>{{ $row->ttt2 ?? '-' }}</td>
                        <td>{{ $row->lain ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="11" class="text-center py-4">Belum ada data transkrip.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Ringkasan total -->
        @php
            $totalSks = $transkrip->sum('sks');
            $lulus = $transkrip->filter(fn($item) => $item->bu == '1')->count();
            $totalMatkul = $transkrip->count();
        @endphp
        <div class="mt-4 p-4 bg-transparent rounded-lg">
            <p><strong>Total SKS:</strong> {{ $totalSks }}</p>
            <p><strong>Total Mata Kuliah:</strong> {{ $totalMatkul }}</p>
            <p><strong>Lulus:</strong> {{ $lulus }}</p>
        </div>
    </div>
</x-layout>