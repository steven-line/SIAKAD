<x-layout title="Transkrip Nilai">

    {{-- CSS khusus print --}}
    <style>
        @media print {

            /* 🔥 Sembunyikan semua elemen */
            * {
                visibility: hidden;
            }

            /* ✅ Tampilkan hanya area transkrip */
            .print-area, .print-area * {
                visibility: visible;
            }

            /* 🔥 Posisikan ke kiri atas full */
            .print-area {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                margin: 0;
                padding: 20px;
                background: white;
            }

            /* ❌ Elemen yang tidak perlu */
            .no-print {
                display: none !important;
            }

            /* ✅ Rapihin tabel */
            table {
                border-collapse: collapse;
                width: 100%;
            }

            table, th, td {
                border: 1px solid black;
            }

            th, td {
                padding: 8px;
                text-align: center;
            }

            body {
                margin: 0;
            }
        }
    </style>

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

    {{-- 🔥 PRINT AREA START --}}
    <div class="container mx-auto p-4 print-area">

        {{-- BUTTON PRINT --}}
        <div class="mb-4 no-print">
            <button onclick="window.print()" class="btn btn-primary">
                Cetak Transkrip
            </button>
        </div>

        <h1 class="text-2xl font-bold mb-4 text-center">Transkrip Nilai</h1>

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
    {{-- 🔥 PRINT AREA END --}}


</x-layout>