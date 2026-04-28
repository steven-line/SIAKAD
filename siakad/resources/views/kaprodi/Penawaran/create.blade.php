<x-layout>
<div class="p-6 text-white max-w-4xl mx-auto">

    <h1 class="text-2xl font-bold text-center mb-6">
        Penawaran Mata Kuliah
    </h1>

    <div class="bg-gray-800 p-6 rounded-lg shadow">

        <form method="POST" action="{{ route('kaprodi.penawaran.store') }}">
            @csrf

            <div class="grid grid-cols-2 gap-4">

                <!-- KODE MK -->
                <div>
                    <label class="text-sm text-gray-400">Kode MK</label>
                    <input type="text" name="kodemk"
                        class="w-full p-2 mt-1 bg-gray-700 rounded focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- NAMA MK -->
                <div>
                    <label class="text-sm text-gray-400">Nama Mata Kuliah</label>
                    <input type="text" name="nama_mk"
                        class="w-full p-2 mt-1 bg-gray-700 rounded">
                </div>

                <!-- SEMESTER -->
                <div>
                    <label class="text-sm text-gray-400">Semester</label>
                    <select name="semester"
                        class="w-full p-2 mt-1 bg-gray-700 rounded">
                        <option>Ganjil</option>
                        <option>Genap</option>
                    </select>
                </div>

                <!-- TAHUN -->
                <div>
                    <label class="text-sm text-gray-400">Tahun Ajaran</label>
                    <input type="text" name="tahun"
                        placeholder="2025/2026"
                        class="w-full p-2 mt-1 bg-gray-700 rounded">
                </div>

                <!-- HARI -->
                <div>
                    <label class="text-sm text-gray-400">Hari</label>
                    <select name="hari"
                        class="w-full p-2 mt-1 bg-gray-700 rounded">
                        <option>Senin</option>
                        <option>Selasa</option>
                        <option>Rabu</option>
                        <option>Kamis</option>
                        <option>Jumat</option>
                        <option>Sabtu</option>
                    </select>
                </div>

                <!-- DOSEN -->
                <div>
                    <label class="text-sm text-gray-400">Dosen</label>
                    <input type="text" name="dosen"
                        class="w-full p-2 mt-1 bg-gray-700 rounded">
                </div>

                <!-- JAM -->
                <div>
                    <label class="text-sm text-gray-400">Jam Mulai</label>
                    <input type="time" name="jam_mulai"
                        class="w-full p-2 mt-1 bg-gray-700 rounded">
                </div>

                <div>
                    <label class="text-sm text-gray-400">Jam Selesai</label>
                    <input type="time" name="jam_selesai"
                        class="w-full p-2 mt-1 bg-gray-700 rounded">
                </div>

                <!-- PAGI / MALAM -->
                <div>
                    <label class="text-sm text-gray-400">Kelas</label>
                    <select name="kelas"
                        class="w-full p-2 mt-1 bg-gray-700 rounded">
                        <option value="pagi">Pagi</option>
                        <option value="malam">Malam</option>
                    </select>
                </div>

                <!-- KETERANGAN -->
                <div>
                    <label class="text-sm text-gray-400">Keterangan</label>
                    <input type="text" name="keterangan"
                        class="w-full p-2 mt-1 bg-gray-700 rounded">
                </div>

            </div>

            <!-- BUTTON -->
            <div class="flex justify-end gap-3 mt-6">
                <a href="/kaprodi/penawaran"
                   class="px-4 py-2 bg-gray-600 rounded hover:bg-gray-500">
                    Batal
                </a>

                <button type="submit"
                    class="px-4 py-2 bg-blue-600 rounded hover:bg-blue-500">
                    Simpan
                </button>
            </div>

        </form>

    </div>

</div>
</x-layout>