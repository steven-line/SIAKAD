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
                    <label class="text-sm text-gray-400">
                        Mata Kuliah
                    </label>

                    <select
                        name="kodemk"
                        class="w-full p-2 mt-1 bg-gray-700 rounded"
                    >
                        @foreach($matkuls as $mk)
                            <option value="{{ $mk->kodemk }}">
                                {{ $mk->kodemk }}
                                -
                                {{ $mk->nama }}
                                ({{ $mk->sks }} SKS)
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- DOSEN -->
                <div>
                    <label class="text-sm text-gray-400">
                        Dosen
                    </label>

                    <select
                        name="dosen"
                        class="w-full p-2 mt-1 bg-gray-700 rounded"
                    >
                        @foreach($dosens as $dsn)
                            <option value="{{ $dsn->nama }}">
                                {{ $dsn->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- SEMESTER -->
                <div>
                    <label class="text-sm text-gray-400">
                        Semester
                    </label>

                    <select
                        name="semester"
                        class="w-full p-2 mt-1 bg-gray-700 rounded"
                    >
                        @for($i=1; $i<=8; $i++)
                            <option value="{{ $i }}">
                                {{ $i }}
                            </option>
                        @endfor
                    </select>
                </div>

                <!-- PERIODE -->
                <div>
                    <label class="text-sm text-gray-400">
                        Periode
                    </label>

                    <input
                        type="text"
                        name="periode"
                        placeholder="2025/2026"
                        class="w-full p-2 mt-1 bg-gray-700 rounded"
                    >
                </div>

                <!-- HARI -->
                <div>
                    <label class="text-sm text-gray-400">
                        Hari
                    </label>

                    <select
                        name="hari"
                        class="w-full p-2 mt-1 bg-gray-700 rounded"
                    >
                        <option value="Senin">Senin</option>
                        <option value="Selasa">Selasa</option>
                        <option value="Rabu">Rabu</option>
                        <option value="Kamis">Kamis</option>
                        <option value="Jumat">Jumat</option>
                        <option value="Sabtu">Sabtu</option>
                    </select>
                </div>

                <!-- SESI -->
                <div>
                    <label class="text-sm text-gray-400">
                        Sesi
                    </label>

                    <select
                        name="sesi"
                        id="sesi"
                        class="w-full p-2 mt-1 bg-gray-700 rounded"
                    >
                        <option value="1">
                            Sesi 1 (Pagi)
                        </option>

                        <option value="2">
                            Sesi 2 (Malam)
                        </option>
                    </select>
                </div>

                <!-- JAM MULAI -->
                <div>
                    <label class="text-sm text-gray-400">
                        Jam Mulai
                    </label>

                    <select
                        name="mulaipukul"
                        id="mulaipukul"
                        class="w-full p-2 mt-1 bg-gray-700 rounded"
                    >
                    </select>
                </div>

                <!-- JAM SELESAI -->
                <div>
                    <label class="text-sm text-gray-400">
                        Jam Selesai
                    </label>

                    <select
                        name="selesaipukul"
                        id="selesaipukul"
                        class="w-full p-2 mt-1 bg-gray-700 rounded"
                    >
                    </select>
                </div>

                <!-- JURUSAN -->
                <div>
                    <label class="text-sm text-gray-400">
                        Jurusan
                    </label>

                    <input
                        type="text"
                        value="{{ auth()->user()->dosen->prodi }}"
                        disabled
                        class="w-full p-2 mt-1 bg-gray-700 rounded text-gray-300"
                    >
                </div>

                <!-- KELAS -->
                <div>
                    <label class="text-sm text-gray-400">
                        Kelas
                    </label>

                    <select
                        name="pataum"
                        class="w-full p-2 mt-1 bg-gray-700 rounded"
                    >
                        <option value="P">
                            Pagi
                        </option>

                        <option value="M">
                            Malam
                        </option>
                    </select>
                </div>

                <!-- PAGU -->
                <div>
                    <label class="text-sm text-gray-400">
                        Pagu
                    </label>

                    <input
                        type="number"
                        name="pagu"
                        class="w-full p-2 mt-1 bg-gray-700 rounded"
                    >
                </div>

                <!-- KETERANGAN -->
                <div class="col-span-2">
                    <label class="text-sm text-gray-400">
                        Keterangan
                    </label>

                    <input
                        type="text"
                        name="keterangan"
                        class="w-full p-2 mt-1 bg-gray-700 rounded"
                    >
                </div>

            </div>

            <div class="flex justify-end mt-6">
                <button
                    type="submit"
                    class="px-4 py-2 bg-blue-600 rounded hover:bg-blue-500"
                >
                    Simpan
                </button>
            </div>

        </form>

    </div>

</div>

<script>
    const sesiSelect = document.getElementById('sesi');

    const mulaiSelect = document.getElementById('mulaipukul');
    const selesaiSelect = document.getElementById('selesaipukul');

    // 🔥 data dari controller
    const jamPagi = @json($jamSlotsPagi);
    const jamMalam = @json($jamSlotsMalam);

    // 🔥 isi dropdown
    function isiJam(slots)
    {
        mulaiSelect.innerHTML = '';
        selesaiSelect.innerHTML = '';

        slots.forEach(jam => {

            mulaiSelect.innerHTML += `
                <option value="${jam}">
                    ${jam}
                </option>
            `;

            selesaiSelect.innerHTML += `
                <option value="${jam}">
                    ${jam}
                </option>
            `;
        });
    }

    // 🔥 default sesi pagi
    isiJam(jamPagi);

    // 🔥 ketika sesi berubah
    sesiSelect.addEventListener('change', function () {

        if (this.value == '1') {

            isiJam(jamPagi);

        } else {

            isiJam(jamMalam);

        }

    });
</script>

</x-layout>