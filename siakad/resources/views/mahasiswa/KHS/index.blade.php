<x-layout title="KHS Mahasiswa">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Kartu Hasil Studi (KHS)</h1>

        @forelse ($grouped as $periode => $items)
            <div class="mb-8">
                <h2 class="text-xl font-semibold mb-2 bg-gray-100 p-2 rounded">Periode: {{ $periode }}</h2>
                <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100">
                    <table class="table">
                        <thead class="bg-blue-500 text-white">
                            <tr>
                                <th>No</th>
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
                            @foreach ($items as $index => $row)
                            <tr>
                                <td>{{ $index + 1 }}</td>
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
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Ringkasan per semester (opsional) -->
                @php
                    $totalSks = $items->sum('sks');
                    $lulus = $items->filter(fn($item) => $item->bu == '1')->count();
                    $totalMatkul = $items->count();
                @endphp
                <div class="mt-2 text-sm text-gray-600">
                    <span class="mr-4">Total SKS: {{ $totalSks }}</span>
                    <span class="mr-4">Mata Kuliah: {{ $totalMatkul }}</span>
                    <span>Lulus: {{ $lulus }}</span>
                </div>
            </div>
        @empty
            <div class="text-center py-4">Belum ada data KHS.</div>
        @endforelse
    </div>
</x-layout>