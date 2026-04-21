<x-layout>
<div class="p-6 text-white max-w-xl mx-auto">

    <h1 class="text-2xl font-bold mb-6 text-center">Edit Jadwal</h1>

    <form method="POST" action="/kaprodi/kelola_jadwal/update/{{ $jadwal->id }}">
        @csrf

        <input type="hidden" name="sesi" value="{{ $jadwal->sesi }}">

        <div class="space-y-4">

            <div>
                <label>Kode MK</label>
                <input type="text" name="kodemk" value="{{ $jadwal->kodemk }}"
                    class="w-full p-2 bg-gray-700 rounded">
            </div>

            <div>
                <label>Nama MK</label>
                <input type="text" name="nama_mk" value="{{ $jadwal->nama_mk }}"
                    class="w-full p-2 bg-gray-700 rounded">
            </div>

            <div>
                <label>SKS</label>
                <input type="number" name="sks" value="{{ $jadwal->sks }}"
                    class="w-full p-2 bg-gray-700 rounded">
            </div>

        </div>

        <div class="flex justify-between mt-6">
            <a href="/kaprodi/kelola_jadwal"
               class="bg-gray-600 px-4 py-2 rounded">
                Kembali
            </a>

            <button type="submit"
                class="bg-blue-600 px-4 py-2 rounded">
                Update
            </button>
        </div>

    </form>

</div>
</x-layout>