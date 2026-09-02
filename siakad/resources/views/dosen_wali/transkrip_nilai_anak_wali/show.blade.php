<x-layout title="Transkrip Nilai">
    <div class="no-print">
        <a class="btn btn-primary btn-outline mb-6 gap-2" href="{{ route('transkrip_nilai_anak_wali.index') }}">
            <svg xmlns="http://w3.org" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Previous page
        </a>
    </div>

    <!-- Cetak Pengaturan CSS Media Print Khusus Lembar Transkrip -->
    <style>
        @media print {
            * { visibility: hidden; }
            .print-area, .print-area * { visibility: visible; }
            .print-area {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                margin: 0;
                padding: 20px;
                background: white;
                color: black !important;
            }
            .no-print { display: none !important; }
            table { border-collapse: collapse; width: 100%; }
            table, th, td { border: 1px solid black !important; color: black !important; }
            th, td { padding: 8px; text-align: center; }
            body { margin: 0; background: white; }
        }
    </style>

    {{-- PRINT AREA TRANSKRIP GABUNGAN --}}
    <div class="container mx-auto p-4 text-base-content print-area">
        
        <div class="mb-6 no-print flex justify-between items-center">
            <h1 class="text-2xl font-bold tracking-wide uppercase">Transkrip Nilai Mahasiswa</h1>
            <button onclick="window.print()" class="btn btn-primary gap-2 shadow-md">
                <svg xmlns="http://w3.org" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
                Cetak Transkrip Berkas
            </button>
        </div>

        <div class="grid grid-cols-[70%_30%] justify-between px-4 mb-6">
            <div>
                <p class="font-bold">Periode: {{ $informasiUmum['periode'] ?? 'N/A' }}</p>
                <p class="font-bold">Semester: {{ $informasiUmum['semester'] ?? 'N/A' }}</p>
                <p class="font-bold">Program studi: {{ $informasiUmum['program_studi'] ?? 'N/A' }}</p>
            </div>
            <div class="cols-start-2 cols-end-3">
                <p class="font-bold">NRP: {{ $informasiUmum['nrp'] ?? 'N/A' }}</p>
                <p class="font-bold">Nama: {{ $informasiUmum['nama'] ?? 'N/A' }}</p>
                <p class="font-bold">Dosen Wali: {{ $informasiUmum['dosen_wali'] ?? 'N/A' }}</p>
            </div>
        </div>

        <div class="overflow-x-auto rounded-xl border border-base-content/10 bg-base-100 shadow-sm">
            <table class="table w-full">
                <!-- bg-primary & text-primary-content menjamin text tetap terbaca jelas di dark mode -->
                <thead class="bg-primary text-primary-content text-center">
                    <tr>
                        <th class="w-12">No</th>
                        <th>Kode</th>
                        <th class="text-left">Mata Kuliah</th>
                        <th>SKS</th>
                        <th>Grade</th>
                        <th>Mutu</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @forelse ($transkripWithMutu as $index => $row)
                        @php
                            // Deteksi jika baris ini berasal dari data nilai_transfer di controller
                            $isRowTransfer = (isset($row->tahun_ajaran) && $row->tahun_ajaran === 'MATA KULIAH TRANSFER');
                        @endphp
                        <tr class="hover:bg-base-200/40 border-b border-base-content/5">
                            <td class="font-medium">{{ $index + 1 }}</td>
                            <td class="font-mono text-sm tracking-wide font-bold text-secondary">{{ $row->kode }}</td>
                            <td class="text-left font-medium">
                                <div class="flex items-center gap-2">
                                    <span>{{ $row->nama_mk ?? '-' }}</span>
                                    @if($isRowTransfer)
                                        <span class="badge badge-ghost badge-xs text-[10px] uppercase font-bold text-base-content/50 border border-base-content/20 no-print">
                                            Transfer
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="font-mono font-semibold">{{ $row->sks ?? 0 }}</td>
                            <td class="font-mono font-bold">
                                <span class="{{ in_array($row->na, ['A', 'AB', 'B']) ? 'text-success' : 'text-warning' }}">
                                    {{ $row->na ?? '-' }}
                                </span>
                            </td>
                            <td class="font-mono">{{ number_format($row->mutu, 2, '.', '') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-8 text-base-content/50 italic">Belum ada data transkrip kumulatif anak wali.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Ringkasan Akumulasi Total Transkrip Paling Bawah -->
        <div class="mt-6 p-5 border border-base-content/10 bg-base-200/30 rounded-xl grid grid-cols-1 md:grid-cols-3 gap-4 text-center md:text-left font-bold shadow-sm">
            <div class="p-3 bg-base-100 rounded-lg border border-base-content/5 shadow-sm">
                <span class="text-xs uppercase tracking-wider text-base-content/50 block mb-1">Total SKS Diakui</span>
                <span class="text-2xl font-mono text-primary font-black">{{ $total_sks ?? 0 }}</span> <span class="text-xs text-base-content/60 font-semibold">SKS</span>
            </div>

            <div class="p-3 bg-base-100 rounded-lg border border-base-content/5 shadow-sm">
                <span class="text-xs uppercase tracking-wider text-base-content/50 block mb-1">Total Nilai Mutu</span>
                <span class="text-2xl font-mono text-primary font-black">{{ number_format($total_mutu ?? 0, 2, '.', '') }}</span>
            </div>

            <div class="p-3 bg-primary text-primary-content rounded-lg shadow-md">
                <span class="text-xs uppercase tracking-wider opacity-70 block mb-1">Indeks Prestasi Kumulatif (IPK)</span>
                <span class="text-3xl font-mono font-black tracking-wide">{{ number_format($ipk ?? 0, 2, '.', '') }}</span>
            </div>
        </div>
    </div>
</x-layout>
