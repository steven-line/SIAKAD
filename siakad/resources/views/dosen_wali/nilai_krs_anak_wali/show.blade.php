<x-layout title="Nilai KRS Mahasiswa">
    <div>
        
        <a class="join-item btn btn-primary mb-10" href="{{ route('nilai_krs_anak_wali.index') }}">
            ⮜ Previous page
        </a>
    </div>

    <div class="space-y-4">
        
        <div class="p-4 rounded-box border border-base-300 bg-base-100">
            <h2 class="text-xl font-bold">
                NRP: {{ $mahasiswa->nrp }}
            </h2>
            <p class="mt-1">
                Dosen Wali: {{ $mahasiswa->dosen_wali }}
            </p>
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
                        <th>TTT3</th>
                        <th>UTS</th>
                        <th>UAS</th>
                        <th>Lain</th>
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

                            <td>
                                @if($row->status === 'B')
                                    <span class="badge badge-success">Baru</span>
                                @elseif($row->status === 'U')
                                    <span class="badge badge-error">Ulang</span>
                                @else
                                    {{ $row->status ?? '-' }}
                                @endif
                            </td>

                            <td>{{ $row->ttt1 !== null ? number_format($row->ttt1, 2) : '-' }}</td>
                            <td>{{ $row->ttt2 !== null ? number_format($row->ttt2, 2) : '-' }}</td>
                            <td>{{ $row->ttt3 !== null ? number_format($row->ttt3, 2) : '-' }}</td>
                            <td>{{ $row->uts !== null ? number_format($row->uts, 2) : '-' }}</td>
                            <td>{{ $row->uas !== null ? number_format($row->uas, 2) : '-' }}</td>
                            <td>{{ $row->lain !== null ? number_format($row->lain, 2) : '-' }}</td>
                            <td>{{ $row->na ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="12" class="text-center py-4">
                                Belum ada data nilai KRS
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</x-layout>