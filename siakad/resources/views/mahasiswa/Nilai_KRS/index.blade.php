<x-layout title="Nilai KRS Mahasiswa">
    <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100">
        <table class="table">
            <thead class="bg-green-500 text-white">
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Mata Kuliah</th>
                    <th>SKS</th>
                    <th>Status</th>
                    <th>TTT1</th>
                    <th>TTT2</th>
                    <th>UTS</th>
                    <th>UAS</th>
                    <th>Lain-lain</th>
                    <th>Grade</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($nilaiKrs as $index => $row)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $row->KODE }}</td>
                    <td>{{ $row->nama_mk ?? '-' }}</td>
                    <td>{{ $row->SKS ?? '-' }}</td>
                    <td class="text-center">
                        @if($row->BU == '1')
                            <span class="badge bg-green-500 text-white px-2 py-1 rounded">Lulus</span>
                        @elseif($row->BU == '0')
                            <span class="badge bg-red-500 text-white px-2 py-1 rounded">Tidak Lulus</span>
                        @else
                            {{ $row->BU ?? '-' }}
                        @endif
                    </td>
                    <td>{{ number_format($row->TTT1, 2) ?? '-' }}</td>
                    <td>{{ number_format($row->TTT2, 2) ?? '-' }}</td>
                    <td>{{ number_format($row->UTS, 2) ?? '-' }}</td>
                    <td>{{ number_format($row->UAS, 2) ?? '-' }}</td>
                    <td>{{ number_format($row->LAIN, 2) ?? '-' }}</td>
                    <td>{{ $row->NA ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="11" class="text-center py-4">Belum ada data nilai KRS</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layout>