<x-layout>
<div class="p-6 text-white">

    <h1 class="text-2xl font-bold mb-6">
        Jadwal Mata Kuliah
    </h1>

    @php
        $hariList = [
            'Senin',
            'Selasa',
            'Rabu',
            'Kamis',
            'Jumat',
            'Sabtu'
        ];
    @endphp

    @foreach($hariList as $hari)

        @php
            $dataHari = $jadwals->where('hari', $hari);
        @endphp

        @if($dataHari->count())

        <div class="mb-8">

            <div class="inline-block bg-gray-700 px-4 py-2 rounded font-bold mb-3">
                {{ $hari }}
            </div>

            <div class="overflow-x-auto">

                <table class="w-full border border-gray-700 text-sm">

                    <thead class="bg-gray-800 text-gray-300">
                        <tr>
                            <th class="p-2 border">No</th>
                            <th class="p-2 border">MBKM</th>
                            <th class="p-2 border">Kode MK</th>
                            <th class="p-2 border">Mata Kuliah</th>
                            <th class="p-2 border">Dosen</th>
                            <th class="p-2 border">Hari</th>
                            <th class="p-2 border">Pukul</th>
                            <th class="p-2 border">SKS</th>
                            <th class="p-2 border">Semester</th>
                            <th class="p-2 border">Kelas</th>
                            <th class="p-2 border">Pagu</th>
                        </tr>
                    </thead>

                    <tbody class="bg-gray-900">

                        @foreach($dataHari->values() as $i => $item)

                        <tr class="hover:bg-gray-800">

                            {{-- NO --}}
                            <td class="p-2 border text-center">
                                {{ $i + 1 }}
                            </td>

                            {{-- MBKM --}}
                            <td class="p-2 border text-center">
                                @if($item->MBKM)
                                    <span class="text-green-400 font-bold">
                                        Ya
                                    </span>
                                @else
                                    <span class="text-red-400">
                                        Tidak
                                    </span>
                                @endif
                            </td>

                            {{-- KODE MK --}}
                            <td class="p-2 border font-semibold">
                                {{ $item->kodemk }}
                            </td>

                            {{-- NAMA MK --}}
                            <td class="p-2 border">

                                <a
                                    href="{{ route('jadwal.show', $item->recno) }}"
                                    class="text-blue-400 hover:underline font-semibold"
                                >
                                    {{ $item->mk->nama ?? '-' }}
                                </a>

                            </td>

                            {{-- DOSEN --}}
                            <td class="p-2 border">
                                {{ $item->dosen }}
                            </td>

                            {{-- HARI --}}
                            <td class="p-2 border">
                                {{ $item->hari }}
                            </td>

                            {{-- JAM --}}
                            <td class="p-2 border">

                                {{ \Carbon\Carbon::parse($item->mulaipukul)->format('H:i') }}

                                -

                                {{ \Carbon\Carbon::parse($item->selesaipukul)->format('H:i') }}

                            </td>

                            {{-- SKS --}}
                            <td class="p-2 border text-center">
                                {{ $item->matkul->sks ?? '-' }}
                            </td>

                            {{-- SEMESTER --}}
                            <td class="p-2 border text-center">
                                {{ $item->semester }}
                            </td>

                            {{-- KELAS --}}
                            <td class="p-2 border text-center">

                                @if($item->pataum == 'P')
                                    Pagi
                                @elseif($item->pataum == 'M')
                                    Malam
                                @else
                                    {{ $item->pataum }}
                                @endif

                            </td>

                            {{-- PAGU --}}
                            <td class="p-2 border text-center">
                                {{ $item->pagu }}
                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

        @endif

    @endforeach

</div>
</x-layout>