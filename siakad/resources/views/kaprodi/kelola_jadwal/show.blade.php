<x-layout>

<div class="p-6 text-white">

    <h1 class="text-2xl font-bold mb-6">
        Detail Jadwal
    </h1>

    <div class="bg-gray-800 p-4 rounded mb-6">

        <div><b>Kode MK:</b> {{ $jadwal->kodemk }}</div>

        <div>
            <b>Mata Kuliah:</b>
            {{ $jadwal->matkul->nama ?? '-' }}
        </div>

        <div><b>Dosen:</b> {{ $jadwal->dosen }}</div>

        <div><b>Hari:</b> {{ $jadwal->hari }}</div>

        <div>
            <b>Jam:</b>
            {{ \Carbon\Carbon::parse($jadwal->mulaipukul)->format('H:i') }}
            -
            {{ \Carbon\Carbon::parse($jadwal->selesaipukul)->format('H:i') }}
        </div>

    </div>

    <h2 class="text-xl font-bold mb-4">
        Mahasiswa Terdaftar
    </h2>

    <table class="w-full border border-gray-700">

        <thead class="bg-gray-800">
            <tr>
                <th class="border p-2">No</th>
                <th class="border p-2">NRP</th>
                <th class="border p-2">Status</th>
                <th class="border p-2">SKS</th>
            </tr>
        </thead>

        <tbody class="bg-gray-900">

            @forelse($jadwal->registrasis as $i => $reg)

            <tr>
                <td class="border p-2">{{ $i+1 }}</td>
                <td class="border p-2">{{ $reg->nrp }}</td>
                <td class="border p-2">{{ $reg->status }}</td>
                <td class="border p-2">{{ $reg->sks }}</td>
            </tr>

            @empty

            <tr>
                <td colspan="4" class="border p-4 text-center text-gray-400">
                    Belum ada mahasiswa terdaftar
                </td>
            </tr>

            @endforelse

        </tbody>

    </table>

</div>

</x-layout>