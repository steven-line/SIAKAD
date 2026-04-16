<x-layout>
<div class="p-6 text-white">

    <h1 class="text-2xl font-bold mb-6">Kelola Jadwal Mata Kuliah</h1>

    <div class="overflow-x-auto">
        <table class="w-full border border-gray-700 rounded-lg overflow-hidden text-center">
            
            <!-- HEADER -->
            <thead class="bg-gray-800 text-gray-300">
                <tr>
                    <th class="p-3 border border-gray-700">Sesi / Jam</th>
                    <th class="p-3 border border-gray-700">Senin</th>
                    <th class="p-3 border border-gray-700">Selasa</th>
                    <th class="p-3 border border-gray-700">Rabu</th>
                    <th class="p-3 border border-gray-700">Kamis</th>
                    <th class="p-3 border border-gray-700">Jumat</th>
                    <th class="p-3 border border-gray-700">Sabtu</th>
                </tr>
            </thead>

            <tbody class="bg-gray-900">

            @foreach([
                1 => '08:00 - 11:00',
                2 => '11:00 - 14:00',
                3 => '14:00 - 16:30'
            ] as $sesi => $jam)

            <tr>
                <td class="p-3 border border-gray-700 font-semibold">
                    Sesi {{ $sesi }} <br>
                    <span class="text-gray-400 text-sm">{{ $jam }}</span>
                </td>

                @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'] as $hari)

                    @php
                        $jadwal = $jadwals->firstWhere('hari', $hari)
                                        ? $jadwals->where('hari', $hari)->where('sesi', $sesi)->first()
                                        : null;
                    @endphp

                    <td class="border border-gray-700">

                        @if($jadwal)
                            <!-- ✅ kalau ada jadwal -->
                            <div class="p-2 text-sm">
                                <div class="font-bold">{{ $jadwal->nama_mk }}</div>
                                <div class="text-gray-400">{{ $jadwal->kodemk }}</div>
                                <div class="text-xs">{{ $jadwal->sks }} SKS</div>

                                <div class="mt-2 flex justify-center gap-2">
                                    <a href="/kaprodi/kelola_jadwal/edit/{{ $jadwal->id }}"
                                    class="text-yellow-400 text-xs">Edit</a>

                                    <form action="/kaprodi/kelola_jadwal/delete/{{ $jadwal->id }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-400 text-xs">Hapus</button>
                                    </form>
                                </div>
                            </div>

                        @else
                            <!-- ➕ kalau kosong -->
                            <a href="/kaprodi/kelola_jadwal/buat?hari={{ $hari }}&sesi={{ $sesi }}"
                            class="block w-full h-full p-6 text-center hover:bg-gray-700 text-gray-400">
                                +
                            </a>
                        @endif

                    </td>

                @endforeach
            </tr>

            @endforeach

            </tbody>
        </table>
    </div>

</div>
</x-layout>