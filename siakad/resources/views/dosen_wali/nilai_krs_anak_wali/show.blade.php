<x-layout>  
@if (isset($periodeKosong) && $periodeKosong)
    <div role="alert" class="alert alert-info mb-6">
        <span>
            {{ $periodeKosong }}
        </span>
    </div>
@endif

<!-- Notifikasi pengumuman ditaruh di luar tanpa else agar tidak menyembunyikan tabel di bawahnya -->
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

@foreach($krsMahasiswa as $krs)
    @php
        // Cek apakah item looping saat ini merupakan blok nilai transfer
        $isTransfer = ($krs['periode'] === 'MATA KULIAH TRANSFER');
        if (!$isTransfer) {
            $regulerCount++;
        }
    @endphp

    <div class="flex justify-between px-4 text-base-content items-center mt-6">
        <div class="font-bold">Periode: {{ $krs['periode'] }}</div>
        <div class="font-bold mb-4">
            Semester: {{ $krs['semester'] }} - 
            <span class="badge badge-primary badge-sm font-mono font-bold text-primary-content px-2"> 
                @if($isTransfer)
                    <!-- Pendekatan Terbaik Akademik: Menampilkan kata Diakui -->
                    Diakui
                @else
                    <!-- Jika reguler, indeks langsung melompat melanjutkan angka setelah semester transfer -->
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
                    <th class="text-center">Sts</th>
                    @if(!$isTransfer)
                        <!-- Kolom Nilai Pecahan disembunyikan jika statusnya adalah Blok Transfer -->
                        <th class="text-center">TTT1</th>
                        <th class="text-center">TTT2</th>
                        <th class="text-center">UTS</th>
                        <th class="text-center">UAS</th>
                        <th class="text-center">LAIN</th>
                    @endif
                    <th class="text-center">GRADE</th>
                </tr>
            </thead>
            <tbody class="bg-base-100 text-base-content">
                @foreach($krs['matkul'] as $item) 
                    <tr class="hover:bg-base-200/50 border-b border-base-content/5">
                        <td class="text-center font-medium">{{ $loop->iteration }}</td>
                        <td class="font-mono text-sm font-bold tracking-wide">{{ $item['kode'] }}</td>
                        <td>{{ $item['mata_kuliah'] }}</td>
                        <td class="text-center font-mono">{{ $item['sks'] }}</td>
                        <td class="text-center">
                            <span class="badge badge-sm {{ $isTransfer ? 'badge-ghost' : 'badge-neutral text-neutral-content' }}">
                                {{ $item['status'] }}
                            </span>
                        </td>
                        @if(!$isTransfer)
                            <!-- Baris isi komponen nilai pecahan disembunyikan untuk Blok Transfer -->
                            <td class="text-center font-mono text-xs text-base-content/70">{{ $item['ttt1'] ?? '0.00' }}</td>
                            <td class="text-center font-mono text-xs text-base-content/70">{{ $item['ttt2'] ?? '0.00' }}</td>
                            <td class="text-center font-mono text-xs text-base-content/70">{{ $item['uts'] ?? '0.00' }}</td>
                            <td class="text-center font-mono text-xs text-base-content/70">{{ $item['uas'] ?? '0.00' }}</td>
                            <td class="text-center font-mono text-xs text-base-content/70">{{ $item['lain'] ?? '0.00' }}</td>
                        @endif
                        <td class="text-center font-mono font-bold">
                            <!-- Pewarnaan grade yang adaptif dan kontras di dark mode -->
                            <span class="{{ in_array($item['grade'], ['A', 'AB', 'B']) ? 'text-success' : 'text-warning' }}">
                                {{ $item['grade'] ?? 'E' }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="px-4 mt-2 font-bold text-base-content/80 text-right text-sm mb-6">
        Total SKS Semester Ini: <span class="text-primary font-mono text-base ml-1">{{ $krs['total_sks'] }} SKS</span>
    </div>
@endforeach
 
</x-layout>
