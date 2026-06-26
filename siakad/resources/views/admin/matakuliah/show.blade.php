<x-layout>

<div class="card-body">

    <h2 class="card-title text-2xl font-bold mb-4">
        Detail Mata Kuliah
    </h2>

    <div class="overflow-x-auto">

        <table class="table table-zebra">
            <tbody>

                <tr>
                    <th width="30%">Kode Mata Kuliah</th>
                    <td>{{ $mk->kodemk }}</td>
                </tr>

                <tr>
                    <th>Nama Mata Kuliah</th>
                    <td>{{ $mk->nama }}</td>
                </tr>

                <tr>
                    <th>SKS</th>
                    <td>{{ $mk->sks }}</td>
                </tr>

                <tr>
                    <th>Jenjang Didik</th>
                    <td>{{ $mk->nm_jenj_didik }}</td>
                </tr>

                <tr>
                    <th>Kode Kurikulum</th>
                    <td>{{ $mk->kode_kurikulum }}</td>
                </tr>

                <tr>
                    <th>Prasyarat SKS</th>
                    <td>{{ $mk->prasyaratsks ?: '-' }}</td>
                </tr>

                <tr>
                    <th>Prasyarat Grade</th>
                    <td>{{ $mk->prasyaratgrade ?: '-' }}</td>
                </tr>

                <tr>
                    <th>Status</th>
                    <td>
                        @if($mk->aktif)
                            <span class="badge badge-success">Aktif</span>
                        @else
                            <span class="badge badge-error">Tidak Aktif</span>
                        @endif
                    </td>
                </tr>

            </tbody>
        </table>

    </div>

    {{-- PRASYARAT --}}
    <div class="divider">
        Prasyarat Mata Kuliah
    </div>

    <div class="overflow-x-auto">

        <table class="table table-zebra">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Mata Kuliah Prasyarat</th>
                </tr>
            </thead>

            <tbody>

                @php
                    $prasyarats = [
                        $mk->prasyarat1,
                        $mk->prasyarat2,
                        $mk->prasyarat3,
                        $mk->prasyarat4,
                        $mk->prasyarat5,
                        $mk->prasyarat6,
                        $mk->prasyarat7,
                        $mk->prasyarat8,
                        $mk->prasyarat9,
                        $mk->prasyarat10,
                    ];
                @endphp

                @forelse(array_filter($prasyarats) as $index => $prasyarat)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $prasyarat }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="text-center">
                            Tidak ada prasyarat
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>

    </div>

    {{-- BUTTON --}}
    <div class="card-actions justify-end mt-6">

        <a
            href="{{ route('mk.edit', $mk->kodemk) }}"
            class="btn btn-warning"
        >
            Edit
        </a>

        <a
            href="{{ route('mk.index') }}"
            class="btn btn-primary"
        >
            Kembali
        </a>

    </div>

</div>

</x-layout>