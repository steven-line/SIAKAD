<x-layout title="KRS UWIKA">

@if($statusBlokir == 'TERKUNCI')
    <div role="alert" class="alert alert-error mb-5">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>

        <span>
            KRS Anda sedang terkunci. Anda masih dapat melihat daftar mata kuliah,
            tetapi tidak dapat melakukan pendaftaran.
        </span>
    </div>
@endif
<div class="container mx-auto p-4">
    @php
        // Kelompokkan data berdasarkan hari
        $grouped = $penawaran->groupBy('hari');
        // Urutan hari yang diinginkan
        $order = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
    @endphp

    @foreach ($order as $hari)
        @if($grouped->has($hari))
        <div class="mb-8">
            <h2 class="text-xl font-bold mb-2 text-gray-800 dark:text-white">{{ $hari }}</h2>
            <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100 shadow-sm">
                <table class="table-auto w-full border-collapse">
                    <thead class="bg-green-500 text-white">
                        <tr>
                            <th class="px-4 py-2 text-left w-12">No</th>
                            <th class="px-4 py-2 text-left w-24">Kode</th>
                            <th class="px-4 py-2 text-left w-64">Mata Kuliah</th>
                            <th class="px-4 py-2 text-left w-20">Hari</th>
                            <th class="px-4 py-2 text-left w-40">Pukul (WIB)</th>
                            <th class="px-4 py-2 text-left w-24">Status</th>
                            <th class="px-4 py-2 text-center w-16">SKS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($grouped[$hari] as $index => $item)
                        <tr>
                            <td class="px-4 py-2 text-left">{{ $index + 1 }}</td>
                            <td class="px-4 py-2 text-left">
                                <a href="{{ route('mahasiswa.mata_kuliah.show',  $item->recno) }}" class="dark:text-white">
                                {{ $item->kodemk }}
                                </a>
                            </td>
                            <td class="px-4 py-2 text-left">
                                <a href="{{ route('mahasiswa.mata_kuliah.show', $item->recno) }}" class="dark:text-white">
                                {{ $item->mk->nama ?? '-' }}
                                </a>
                            </td>
                            <td class="px-4 py-2 text-left">
                                <a href="{{ route('mahasiswa.mata_kuliah.show',  $item->recno) }}" class="dark:text-white">
                                {{ $item->hari }}
                                </a>
                            </td>
                            <td class="px-4 py-2 text-left">
                                <a href="{{ route('mahasiswa.mata_kuliah.show',  $item->recno) }}" class="dark:text-white">
                                    {{ $item->mulaipukul->format('H:i') }} - {{ $item->selesaipukul->format('H:i') }}
                                </a>
                            </td>
                            <td class="px-4 py-2 text-left"> <a href="{{ route('mahasiswa.mata_kuliah.show', $item->recno) }}" class="dark:text-white">
                                {{ $item->status ?? 'Tersedia' }}
                                </a>
                            </td>
                            <td class="px-4 py-2 text-center"> 
                                <a href="{{ route('mahasiswa.mata_kuliah.show', $item->recno) }}" class="dark:text-white">
                                {{ $item->mk->sks ?? '-' }}
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    @endforeach

    @if($penawaran->isEmpty())
        <div class="text-center py-4 text-gray-500">Tidak ada data mata kuliah</div>
    @endif
</div>
</x-layout>