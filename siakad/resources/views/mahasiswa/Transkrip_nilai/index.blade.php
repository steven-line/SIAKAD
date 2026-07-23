<x-layout title="Transkrip Nilai">

    {{-- CSS khusus print --}}
    <style>
        @media print {

            * {
                visibility: hidden;
            }

            .print-area,
            .print-area * {
                visibility: visible;
            }

            .print-area {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                margin: 0;
                padding: 20px;
                background: white;
            }

            .no-print {
                display: none !important;
            }

            table {
                border-collapse: collapse;
                width: 100%;
            }

            table,
            th,
            td {
                border: 1px solid black;
            }

            th,
            td {
                padding: 8px;
                text-align: center;
            }

            body {
                margin: 0;
            }
        }
    </style>

    {{-- BLOKIR --}}
    @if($statusBlokir === 'BLOKIR')

        <div role="alert" class="alert alert-error mb-6">
            <span>
                KRS anda terblokir, mohon hubungi bagian keuangan untuk menyelesaikan tunggakan.
            </span>
        </div>

    @else

        {{-- TERKUNCI --}}
        @if($statusBlokir === 'TERKUNCI')
            <div role="alert" class="alert alert-warning mb-6">
                <span>
                    KRS Anda sedang terkunci. Anda masih dapat melihat data, tetapi tidak dapat melakukan perubahan.
                </span>
            </div>
        @endif

        {{-- PERIODE PENGUMUMAN NILAI FINAL --}}
        @if(!empty($periodePengumuman))

            <div role="alert" class="alert alert-warning">
                <div>
                    <h3 class="font-bold text-lg">
                        Pengumuman Nilai Final
                    </h3>

                    <p class="mt-2">
                        Akses <strong>Transkrip Nilai</strong> sedang ditutup karena sedang berada pada periode
                        <strong>Pengumuman Nilai Final</strong>.
                    </p>

                    <div class="mt-3">
                        <p>
                            <strong>Periode Pengumuman :</strong><br>

                            {{ \Carbon\Carbon::parse($pengumumanMulai)->translatedFormat('d F Y, H:i') }}
                            WIB
                            s/d
                            {{ \Carbon\Carbon::parse($pengumumanSelesai)->translatedFormat('d F Y, H:i') }}
                            WIB
                        </p>

                        <p class="mt-2">
                            Transkrip Nilai dapat diakses kembali setelah periode tersebut berakhir.
                        </p>
                    </div>
                </div>
            </div>

        @else

            {{-- PRINT AREA --}}
            <div class="container mx-auto p-4 print-area">

                <div class="mb-4 no-print">
                    <button onclick="window.print()" class="btn btn-primary">
                        Cetak Transkrip
                    </button>
                </div>

                <h1 class="text-2xl font-bold mb-4 text-center">
                    Transkrip Nilai
                </h1>

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
                                    <td colspan="6" class="text-center py-4">
                                        Belum ada data transkrip.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 p-4 bg-transparent rounded">
                    <p>
                        <strong>Total SKS:</strong>
                        {{ $total_sks ?? 0 }}
                    </p>

                    <p>
                        <strong>Total Mutu:</strong>
                        {{ number_format($total_mutu ?? 0, 2) }}
                    </p>

                    <p>
                        <strong>IPK:</strong>
                        {{ number_format($ipk ?? 0, 3) }}
                    </p>
                </div>

            </div>

        @endif

    @endif

</x-layout>