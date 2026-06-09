<x-layout title="KRS UWIKA">
<div class="container mx-auto p-4">
    @php
        // Kelompokkan data berdasarkan hari
        $grouped = $penawaran->groupBy('hari');
        // Urutan hari yang diinginkan (sesuaikan dengan kebutuhan)
        $order = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
    @endphp

    @foreach ($order as $hari)
        @if($grouped->has($hari))
        <div class="mb-8">
            <h2 class="text-xl font-bold mb-2 text-gray-800 dark:text-white">{{ $hari }}</h2>
            <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100">
                <table class="table w-full">
                    <thead class="bg-green-500 text-white">
                        <tr>
                            <th class="px-4 py-2">No</th>
                            <th class="px-4 py-2">Kode</th>
                            <th class="px-4 py-2">Mata Kuliah</th>
                            <th class="px-4 py-2">Hari</th>
                            <th class="px-4 py-2">Pukul (WIB)</th>
                            <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2">SKS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($grouped[$hari] as $index => $item)
                        <tr>
                            <td class="px-4 py-2">{{ $index + 1 }}</td>
                            <td class="px-4 py-2">
                                <a href="{{ route('mata-kuliah.show', $item->kodemk) }}" class="text-blue-400 hover:underline">
                                    {{ $item->kodemk }}
                                </a>
                            </td>
                            <td class="px-4 py-2">
                                <a href="{{ route('mata-kuliah.show', $item->kodemk) }}" class="text-blue-400 hover:underline">
                                    {{ $item->mk->nama ?? '-' }}
                                </a>
                            </td>
                            <td class="px-4 py-2">{{ $item->hari }}</td>
                            <td class="px-4 py-2">
                                {{ $item->mulaipukul->format('H:i:s') }} - {{ $item->selesaipukul->format('H:i:s') }}
                            </td>
                            <td class="px-4 py-2">{{ $item->status ?? 'Tersedia' }}</td>
                            <td class="px-4 py-2">{{ $item->mk->sks ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    @endforeach

    @if($penawaran->isEmpty())
        <div class="text-center py-4">Tidak ada data mata kuliah</div>
    @endif
</div>
</x-layout>