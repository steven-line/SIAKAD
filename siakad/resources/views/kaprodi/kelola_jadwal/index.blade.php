<x-layout>
<div class="p-6 text-white">

    <h1 class="text-2xl font-bold mb-6">Jadwal Mata Kuliah</h1>

    @php
        $hariList = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
    @endphp

    @foreach($hariList as $hari)

        @php
            $dataHari = $jadwals->where('hari', $hari);
        @endphp

        @if($dataHari->count() > 0)

        <!-- 🔥 JUDUL HARI -->
        <div class="mb-6">
            <div class="inline-block bg-gray-700 px-3 py-1 rounded font-bold mb-2">
                {{ $hari }}
            </div>

            <div class="overflow-x-auto">
                <table class="w-full border border-gray-700 text-sm">

                    <!-- HEADER -->
                    <thead class="bg-gray-800 text-gray-300">
                        <tr>
                            <th class="p-2 border">No</th>
                            <th class="p-2 border">Kode</th>
                            <th class="p-2 border">Mata Kuliah</th>
                            <th class="p-2 border">Hari</th>
                            <th class="p-2 border">Pukul</th>
                            <th class="p-2 border">SKS</th>
                        </tr>
                    </thead>

                    <tbody class="bg-gray-900">

                        @foreach($dataHari->values() as $i => $item)
                        <tr class="hover:bg-gray-800">

                            <!-- NO -->
                            <td class="p-2 border">{{ $i+1 }}</td>

                            <!-- KODE -->
                            <td class="p-2 border font-semibold">
                                {{ $item->kodemk }}
                            </td>

                            <!-- MATA KULIAH -->
                            <td class="p-2 border">
                                <a
                                    href="{{ route('kaprodi.jadwal.show', $item->recno) }}"
                                    class="font-semibold text-blue-400 hover:underline"
                                >
                                    {{ $item->matkul->nama ?? '-' }}
                                </a>

                                <div class="text-xs text-gray-400">
                                    {{ $item->dosen }}
                                </div>
                            </td>

                            <!-- HARI -->
                            <td class="p-2 border">
                                {{ strtoupper($item->hari) }}
                            </td>

                            <!-- JAM -->
                            <td class="p-2 border">
                                {{ \Carbon\Carbon::parse($item->mulaipukul)->format('H:i') }}
                                -
                                {{ \Carbon\Carbon::parse($item->selesaipukul)->format('H:i') }}
                            </td>

                            <!-- SKS -->
                            <td class="p-2 border text-center">

                                @php
                                    $mulai = \Carbon\Carbon::parse($item->mulaipukul);
                                    $selesai = \Carbon\Carbon::parse($item->selesaipukul);

                                    $durasi = $mulai->diffInMinutes($selesai);

                                    $sks = $durasi / 50;
                                @endphp

                                {{ $sks }}

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