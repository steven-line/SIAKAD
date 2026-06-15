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

        {{-- SUCCESS --}}
        @if(session('success'))
            <div class="bg-green-600 p-3 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('kaprodi.penawaran.store') }}">
            @csrf

            <div class="grid grid-cols-2 gap-4">

                <!-- MATA KULIAH -->
                <div>
                    <label class="text-sm text-gray-400">Mata Kuliah</label>

                    <select
                        name="kodemk"
                        id="kodemk"
                        class="w-full p-2 mt-1 bg-gray-700 rounded"
                    >
                        @foreach($matkuls as $mk)
                            <option
                                value="{{ $mk->kodemk }}"
                                data-sks="{{ $mk->sks }}"
                                @selected(old('kodemk') == $mk->kodemk)
                            >
                                {{ $mk->kodemk }} - {{ $mk->nama }} ({{ $mk->sks }} SKS)
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- DOSEN -->
                <div>
                    <label class="text-sm text-gray-400">Dosen</label>

                    <select
                        name="dosen"
                        class="w-full p-2 mt-1 bg-gray-700 rounded"
                    >
                        @foreach($dosens as $dsn)
                            <option value="{{ $dsn->nim_dosen}}" @selected(old('dosen') == $dsn->nim_dosen)>
                                {{ $dsn->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- SEMESTER -->
                <div>
                    <label class="text-sm text-gray-400">Semester</label>

                    <select
                        name="semester"
                        class="w-full p-2 mt-1 bg-gray-700 rounded"
                    >
                        @for($i = 1; $i <= 8; $i++)
                            <option value="{{ $i }}" @selected(old('semester') == $i)>
                                {{ $i }}
                            </option>
                        @endfor
                    </select>
                </div>

                <!-- PERIODE -->
                <div>
                    <label class="text-sm text-gray-400">Periode</label>

                    <input
                        type="text"
                        name="periode"
                        placeholder="2025/2026"
                        value="{{ old('periode') }}"
                        class="w-full p-2 mt-1 bg-gray-700 rounded"
                    >
                </div>

                <!-- HARI -->
                <div>
                    <label class="text-sm text-gray-400">Hari</label>

                    <select
                        name="hari"
                        class="w-full p-2 mt-1 bg-gray-700 rounded"
                    >
                        <option value="Senin" @selected(old('hari') == 'Senin')>Senin</option>
                        <option value="Selasa" @selected(old('hari') == 'Selasa')>Selasa</option>
                        <option value="Rabu" @selected(old('hari') == 'Rabu')>Rabu</option>
                        <option value="Kamis" @selected(old('hari') == 'Kamis')>Kamis</option>
                        <option value="Jumat" @selected(old('hari') == 'Jumat')>Jumat</option>
                        <option value="Sabtu" @selected(old('hari') == 'Sabtu')>Sabtu</option>
                    </select>
                </div>

                <!-- SESI -->
                <div>
                    <label class="text-sm text-gray-400">Sesi</label>

                    <select
                        name="sesi"
                        id="sesi"
                        class="w-full p-2 mt-1 bg-gray-700 rounded"
                    >
                        <option value="1" @selected(old('sesi', '1') == '1')>Sesi 1 (Pagi)</option>
                        <option value="2" @selected(old('sesi') == '2')>Sesi 2 (Malam)</option>
                    </select>
                </div>

                <!-- JAM MULAI -->
                <div>
                    <label class="text-sm text-gray-400">Jam Mulai</label>

                    <select
                        name="mulaipukul"
                        id="mulaipukul"
                        class="w-full p-2 mt-1 bg-gray-700 rounded"
                    >
                    </select>
                </div>

                <!-- JAM SELESAI OTOMATIS -->
                <div>
                    <label class="text-sm text-gray-400">Jam Selesai</label>

                    <input
                        type="text"
                        name="selesaipukul"
                        id="selesaipukul"
                        readonly
                        class="w-full p-2 mt-1 bg-gray-700 rounded text-gray-300"
                    >
                </div>

                <!-- JURUSAN -->
                <div>
                <label class="label font-bold mt-2" for="jurusans">Jurusan</label>
                            <select class="select select-bordered w-full" name="jurusans" required>
                                <option disabled selected>Pilih Jurusan</option>
                                @foreach ($jurusans as $jurusan)  
                                    <option value="{{ $jurusan->kode_jurusan }}">{{ $jurusan->nama_jurusan }}</option>  
                                @endforeach
                            </select>
                            <x-forms.error name='jurusan'/>
                </div>

                <!-- KELAS -->
                <div>
                    <label class="text-sm text-gray-400">Kelas</label>

                    <select
                        name="pataum"
                        class="w-full p-2 mt-1 bg-gray-700 rounded"
                    >
                        <option value="P" @selected(old('pataum') == 'P')>Pagi</option>
                        <option value="M" @selected(old('pataum') == 'M')>Malam</option>
                    </select>
                </div>

                <!-- PAGU -->
                <div>
                    <label class="text-sm text-gray-400">Pagu</label>

                    <input
                        type="number"
                        name="pagu"
                        value="{{ old('pagu') }}"
                        class="w-full p-2 mt-1 bg-gray-700 rounded"
                    >
                </div>

                <!-- MBKM -->
                <div>
                    <label class="text-sm text-gray-400">MBKM</label>
                    <div class="mt-2">
                        <input
                            type="checkbox"
                            name="MBKM"
                            value="1"
                            class="w-5 h-5"
                            @checked(old('MBKM'))
                        >
                    </div>
                </div>

                <!-- KETERANGAN -->
                <div class="col-span-2">
                    <label class="text-sm text-gray-400">Keterangan</label>

                    <input
                        type="text"
                        name="keterangan"
                        value="{{ old('keterangan') }}"
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
    const mkSelect = document.getElementById('kodemk');
    const mulaiSelect = document.getElementById('mulaipukul');
    const selesaiInput = document.getElementById('selesaipukul');

    const jamPagi = @json($jamSlotsPagi);
    const jamMalam = @json($jamSlotsMalam);

    function isiJam(slots) {
        const oldMulai = @json(old('mulaipukul'));
        mulaiSelect.innerHTML = '';

        slots.forEach(jam => {
            const selected = oldMulai === jam ? 'selected' : '';
            mulaiSelect.innerHTML += `
                <option value="${jam}" ${selected}>${jam}</option>
            `;
        });
    }

    function addMinutes(time, minutes) {
        const [hours, mins] = time.split(':').map(Number);
        const total = hours * 60 + mins + minutes;

        const newHours = Math.floor(total / 60);
        const newMins = total % 60;

        return String(newHours).padStart(2, '0') + ':' + String(newMins).padStart(2, '0');
    }

    function hitungSelesai() {
        const selectedOption = mkSelect.options[mkSelect.selectedIndex];
        const sks = parseInt(selectedOption.dataset.sks || 0);
        const jamMulai = mulaiSelect.value;

        if (!sks || !jamMulai) {
            selesaiInput.value = '';
            return;
        }

        const durasiMenit = sks * 50;
        selesaiInput.value = addMinutes(jamMulai, durasiMenit);
    }

    function updateJam() {
        if (sesiSelect.value == '2') {
            isiJam(jamMalam);
        } else {
            isiJam(jamPagi);
        }
        hitungSelesai();
    }

    sesiSelect.addEventListener('change', updateJam);
    mkSelect.addEventListener('change', hitungSelesai);
    mulaiSelect.addEventListener('change', hitungSelesai);

    updateJam();
</script>

</x-layout>