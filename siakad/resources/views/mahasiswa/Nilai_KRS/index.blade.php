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


    {{-- ✅ TERKUNCI / NORMAL --}}
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

                    <td>{{ $row->ttt1 !== null ? number_format($row->ttt1, 2) : '-' }}</td>
                    <td>{{ $row->ttt2 !== null ? number_format($row->ttt2, 2) : '-' }}</td>
                    <td>{{ $row->uts  !== null ? number_format($row->uts, 2)  : '-' }}</td>
                    <td>{{ $row->uas  !== null ? number_format($row->uas, 2)  : '-' }}</td>
                    <td>{{ $row->lain !== null ? number_format($row->lain, 2) : '-' }}</td>
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

    @endif

</x-layout>