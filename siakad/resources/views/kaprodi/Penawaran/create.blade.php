<x-layout>
<div class="p-6 text-white max-w-4xl mx-auto">

    <h1 class="text-2xl font-bold text-center mb-6">
        Penawaran Mata Kuliah
    </h1>

    <div class="bg-gray-800 p-6 rounded-lg shadow">

        {{-- ERROR --}}
        @if ($errors->any())
            <div class="bg-red-500 p-3 mb-4 rounded">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('kaprodi.penawaran.store') }}">
            @csrf

            <div class="grid grid-cols-2 gap-4">

                <!-- MATA KULIAH -->
                <div>
                    <label class="text-sm text-gray-400">Mata Kuliah</label>
                    <select name="kodemk" class="w-full p-2 mt-1 bg-gray-700 rounded">
                        @foreach($matkuls as $mk)
                            <option value="{{ $mk->kodemk }}">
                                {{ $mk->kodemk }} - {{ $mk->nama }} ({{ $mk->sks }} SKS)
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- DOSEN -->
                <div>
                    <label class="text-sm text-gray-400">Dosen</label>
                    <select name="dosen" class="w-full p-2 mt-1 bg-gray-700 rounded">
                        @foreach($dosens as $dsn)
                            <option value="{{ $dsn->nama }}">
                                {{ $dsn->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- SEMESTER -->
                <div>
                    <label class="text-sm text-gray-400">Semester</label>
                    <select name="semester" class="w-full p-2 mt-1 bg-gray-700 rounded">
                        @for($i=1; $i<=8; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>

                <!-- PERIODE -->
                <div>
                    <label class="text-sm text-gray-400">Periode</label>
                    <input type="text" name="periode"
                        placeholder="2025/2026"
                        class="w-full p-2 mt-1 bg-gray-700 rounded">
                </div>

                <!-- HARI -->
                <div>
                    <label class="text-sm text-gray-400">Hari</label>
                    <select name="hari" class="w-full p-2 mt-1 bg-gray-700 rounded">
                        <option>Senin</option>
                        <option>Selasa</option>
                        <option>Rabu</option>
                        <option>Kamis</option>
                        <option>Jumat</option>
                        <option>Sabtu</option>
                    </select>
                </div>

                <!-- SESI -->
                <div>
                    <label class="text-sm text-gray-400">Sesi</label>
                    <input type="text" name="sesi"
                        placeholder="Sesi 1 / Sesi 2"
                        class="w-full p-2 mt-1 bg-gray-700 rounded">
                </div>

                <!-- JAM MULAI -->
                <div>
                    <label class="text-sm text-gray-400">Jam Mulai</label>
                    <select name="mulaipukul" class="w-full p-2 mt-1 bg-gray-700 rounded">
                        @foreach($jamSlots as $jam)
                            <option value="{{ $jam }}">{{ $jam }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- JAM SELESAI -->
                <div>
                    <label class="text-sm text-gray-400">Jam Selesai</label>
                    <select name="selesaipukul" class="w-full p-2 mt-1 bg-gray-700 rounded">
                        @foreach($jamSlots as $jam)
                            <option value="{{ $jam }}">{{ $jam }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- JURUSAN -->
                <div>
                    <label class="text-sm text-gray-400">Jurusan</label>
                    <select name="jurusan" class="w-full p-2 mt-1 bg-gray-700 rounded">
                        <option value="TI">Teknik Informatika</option>
                        <option value="SI">Sistem Informasi</option>
                        <option value="MI">Manajemen Informatika</option>
                    </select>
                </div>

                <!-- KELAS -->
                <div>
                    <label class="text-sm text-gray-400">Kelas</label>
                    <select name="pataum" class="w-full p-2 mt-1 bg-gray-700 rounded">
                        <option value="P">Pagi</option>
                        <option value="M">Malam</option>
                    </select>
                </div>

                <!-- PAGU -->
                <div>
                    <label class="text-sm text-gray-400">Pagu</label>
                    <input type="number" name="pagu"
                        class="w-full p-2 mt-1 bg-gray-700 rounded">
                </div>

                <!-- KETERANGAN -->
                <div class="col-span-2">
                    <label class="text-sm text-gray-400">Keterangan</label>
                    <input type="text" name="keterangan"
                        class="w-full p-2 mt-1 bg-gray-700 rounded">
                </div>

            </div>

            <div class="flex justify-end mt-6">
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 rounded hover:bg-blue-500">
                    Simpan
                </button>
            </div>

        </form>

    </div>

</div>
</x-layout>