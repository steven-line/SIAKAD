<x-layout>
@if (isset($periodeKosong) && $periodeKosong)
    <div role="alert" class="alert alert-info mb-6">
        <span>
            {{ $periodeKosong }}
        </span>
    </div>
@endif

<!-- Pengumuman dipisah di atas agar tidak memblokir/menyembunyikan tabel di bawahnya -->
@if (isset($pengumumanKrs) && $pengumumanKrs)
    <div role="alert" class="alert alert-info mb-6">
        <span>
            {{ $pengumumanKrs }}
        </span>
    </div>
@endif

    <div class="grid grid-cols-[70%_30%] justify-between px-4 mb-4 text-base-content">
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

    <hr class="border-base-content/10 my-4">

    <!-- Counter pembantu untuk menghitung indeks semester reguler secara bersih -->
    @php 
        $regulerCount = 0; 
        $semesterTransfer = (int) ($informasiUmum['semester_transfer'] ?? 0);
    @endphp

    @foreach($grouped as $group)
        @php
            // Cek apakah item looping saat ini merupakan blok nilai transfer
            $isTransfer = ($group['is_transfer'] ?? false);
            if (!$isTransfer) {
                $regulerCount++;
            }
        @endphp

    <div class="flex justify-between px-4 text-base-content items-center mt-6">
        <div class="font-bold">Periode: {{ $group['periode'] }}</div>
        <div class="font-bold mb-4">
            Semester: {{ $group['semester'] }} - 
            <span class="badge badge-primary badge-sm font-mono font-bold text-primary-content px-2">
                @if($isTransfer)
                    Diakui
                @else
                    {{ $semesterTransfer + $regulerCount }}
                @endif
            </span>
        </div>
    </div> 

    <div class="overflow-x-auto px-4">
        <table class="table w-full border border-base-content/10">
            <!-- bg-primary & text-primary-content menjamin text tetap terbaca jelas di dark mode -->
            <thead class="bg-primary text-primary-content">
                <tr>
                    <th class="text-center w-12">No</th>
                    <th>Kode</th>
                    <th>Mata Kuliah</th>
                    <th class="text-center">SKS</th>
                    <th class="text-center">Grade</th>
                    <th class="text-center">Mutu</th>
                </tr>
            </thead>
            <tbody class="bg-base-100 text-base-content">
                @foreach($group['items'] as $item) 
                    <tr class="hover:bg-base-200/50 border-b border-base-content/5">
                        <td class="text-center font-medium">{{ $loop->iteration }}</td>
                        <td class="font-mono text-sm font-bold tracking-wide">{{ $item['kode'] }}</td>
                        <td>{{ $item['mata_kuliah'] }}</td>
                        <td class="text-center font-mono">{{ $item['sks'] }}</td>
                        <td class="text-center font-mono font-bold">
                            <span class="{{ in_array($item['grade'], ['A', 'AB', 'B']) ? 'text-success' : 'text-warning' }}">
                                {{ $item['grade'] ?? 'E' }}
                            </span>
                        </td>
                        <td class="text-center font-mono">{{ number_format($item['mutu'], 1, '.', '') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Ringkasan Nilai Per Semester -->
    <div class="px-4 mt-3 mb-8 flex flex-col md:flex-row justify-between items-start md:items-center text-sm font-bold text-base-content/85 bg-base-200/40 p-3 rounded-lg mx-4 border border-base-content/5">
        <div>
            Total SKS: <span class="text-primary font-mono text-base ml-1 mr-4">{{ $group['total_sks'] }} SKS</span>
            Total Mutu: <span class="text-primary font-mono text-base ml-1">{{ number_format($group['total_mutu'], 1, '.', '') }}</span>
        </div>
        <div class="mt-1 md:mt-0">
            @if($isTransfer)
                <span class="text-base-content/50 italic text-xs font-normal">SKS Masuk Konversi (Tidak Memiliki IPS)</span>
            @else
                IPS Semester Ini: <span class="text-success font-mono text-base ml-1">{{ number_format($group['ips'], 2, '.', '') }}</span>
            @endif
        </div>
    </div>
    @endforeach

    <!-- Akumulasi IPK Global Paling Bawah -->
    <div class="mx-4 my-8 p-4 bg-primary text-primary-content rounded-xl shadow-md flex justify-between items-center">
        <div class="font-bold text-lg tracking-wide">Indeks Prestasi Kumulatif (IPK)</div>
        <div class="text-3xl font-black font-mono tracking-wider">
            {{ number_format($ipk, 2, '.', '') }}
        </div>
    </div>

</x-layout>
