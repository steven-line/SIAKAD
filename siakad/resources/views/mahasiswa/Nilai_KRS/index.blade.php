<x-layout title="Nilai KRS Mahasiswa">
@if($statusBlokir == 'TERKUNCI')
<div role="alert" class="alert alert-warning mb-6">
    <svg xmlns="http://www.w3.org/2000/svg"
         class="h-6 w-6 shrink-0 stroke-current"
         fill="none"
         viewBox="0 0 24 24">
        <path stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M13 16h-1v-4h-1m1-4h.01M12 22a10
              10 0 100-20 10 10 0 000 20z"/>
    </svg>

    <span>
        KRS Anda sedang terkunci.
        Anda masih dapat melihat data KHS, tetapi tidak dapat melakukan perubahan KRS.
    </span>
    @endif
</div>
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
                    <td>{{ $row->kode }}</td>
                    <td>{{ $row->nama_mk ?? '-' }}</td>
                    <td>{{ $row->sks ?? '-' }}</td>
                    <td class="text-center">
                        @if($row->status == 'B')
                            <span class="badge bg-green-500 text-white px-2 py-1 rounded">Baru</span>
                        @elseif($row->status == 'U')
                            <span class="badge bg-red-500 text-white px-2 py-1 rounded">Ulang</span>
                        @else
                            {{ $row->status ?? '-' }}
                        @endif
                    </td>
                    <td>{{ number_format($row->ttt1, 2) ?? '-' }}</td>
                    <td>{{ number_format($row->ttt2, 2) ?? '-' }}</td>
                    <td>{{ number_format($row->uts, 2) ?? '-' }}</td>
                    <td>{{ number_format($row->uas, 2) ?? '-' }}</td>
                    <td>{{ number_format($row->lain, 2) ?? '-' }}</td>
                    <td>{{ $row->na ?? '-' }}</td>
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