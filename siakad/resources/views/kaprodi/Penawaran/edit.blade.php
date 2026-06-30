<x-layout>
<div class="p-6 text-white max-w-4xl mx-auto">

    <h1 class="text-2xl font-bold text-center mb-6">
        Edit Penawaran Mata Kuliah
    </h1>

    <div class="bg-gray-800 p-6 rounded-lg shadow">

        @if ($errors->any())
            <div class="bg-red-500 p-3 mb-4 rounded">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form
            method="POST"
            action="{{ route('penawaran.update', $penawaran->recno) }}"
        >
            @csrf
            @method('PATCH')

            <div class="grid grid-cols-2 gap-4">

                {{-- MATA KULIAH --}}
                <div>
                    <label class="text-sm text-gray-400">
                        Mata Kuliah
                    </label>

                    <select
                        name="kodemk"
                        id="kodemk"
                        class="w-full p-2 mt-1 bg-gray-700 rounded"
                    >
                        @foreach($matkuls as $mk)
                            <option
                                value="{{ $mk->kodemk }}"
                                data-sks="{{ $mk->sks }}"
                                @selected(old('kodemk', $penawaran->kodemk) == $mk->kodemk)
                            >
                                {{ $mk->kodemk }} - {{ $mk->nama }} ({{ $mk->sks }} SKS)
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- DOSEN --}}
                <div>
                    <label class="text-sm text-gray-400">
                        Dosen
                    </label>

                    <select
                        name="dosen"
                        class="w-full p-2 mt-1 bg-gray-700 rounded"
                    >
                        @foreach($dosens as $dsn)
                            <option
                                value="{{ $dsn->nim_dosen }}"
                                @selected(old('dosen', $penawaran->dosen) == $dsn->nim_dosen)
                            >
                                {{ $dsn->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- SEMESTER --}}
                <div>
                    <label class="text-sm text-gray-400">Semester</label>

                    <select name="semester_id" class="w-full p-2 mt-1 bg-gray-700 rounded">
                        @forelse($semesters as $s)
                            <option value="{{ $s->id }}">
                                {{ $s->nama }}
                                - {{ $s->periode->tahun_ajaran }}
                                {{ $s->jenis }}
                            </option>
                        @empty
                            <option disabled>Tidak ada semester aktif</option>
                        @endforelse
                    </select>
                </div>

                {{-- HARI --}}
                <div>
                    <label class="text-sm text-gray-400">
                        Hari
                    </label>

                    <select
                        name="hari"
                        class="w-full p-2 mt-1 bg-gray-700 rounded"
                    >
                        @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'] as $hari)
                            <option
                                value="{{ $hari }}"
                                @selected(old('hari', $penawaran->hari) == $hari)
                            >
                                {{ $hari }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- SESI --}}
                <div>
                    <label class="text-sm text-gray-400">
                        Sesi
                    </label>

                    <select
                        name="sesi"
                        id="sesi"
                        class="w-full p-2 mt-1 bg-gray-700 rounded"
                    >
                        <option value="1"
                            @selected(old('sesi', $penawaran->sesi) == '1')>
                            Sesi 1 (Pagi)
                        </option>

                        <option value="2"
                            @selected(old('sesi', $penawaran->sesi) == '2')>
                            Sesi 2 (Malam)
                        </option>
                    </select>
                </div>

                {{-- JAM MULAI --}}
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

                {{-- JAM SELESAI --}}
                <div>
                    <label class="text-sm text-gray-400">
                        Jam Selesai
                    </label>

                    <input
                        type="time"
                        id="selesaipukul"
                        class="w-full p-2 mt-1 bg-gray-600 rounded text-gray-300 cursor-not-allowed"
                        readonly
                        disabled
                    >

                    <input
                        type="hidden"
                        name="selesaipukul"
                        id="selesaipukul_hidden"
                        value="{{ old('selesaipukul', \Carbon\Carbon::parse($penawaran->selesaipukul)->format('H:i')) }}"
                    >
                </div>

                {{-- PRODI --}}
                <div>
                    <label class="text-sm text-gray-400">Prodi</label>

                    <input
                        type="text"
                        value="{{ auth()->user()->dosen->prodi }}"
                        class="w-full p-2 mt-1 bg-gray-600 rounded text-gray-300"
                        readonly
                    >
                </div>

                {{-- KELAS --}}
                <div>
                    <label class="text-sm text-gray-400">
                        Kelas
                    </label>

                    <select
                        name="pataum"
                        class="w-full p-2 mt-1 bg-gray-700 rounded"
                    >
                        <option value="P"
                            @selected(old('pataum', $penawaran->pataum) == 'P')>
                            Pagi
                        </option>

                        <option value="M"
                            @selected(old('pataum', $penawaran->pataum) == 'M')>
                            Malam
                        </option>
                    </select>
                </div>

                {{-- PAGU --}}
                <div>
                    <label class="text-sm text-gray-400">
                        Pagu
                    </label>

                        <input
                            type="number"
                            name="pagu"
                            min="1"
                            max="99"
                            value="{{ old('pagu', $penawaran->pagu) }}"                            
                            oninput="if(this.value > 99) this.value = 99"
                            class="w-full p-2 mt-1 bg-gray-700 rounded"
                    >
                </div>

                {{-- MBKM --}}
                <div>
                    <label class="text-sm text-gray-400">
                        MBKM
                    </label>

                    <div class="mt-2">
                        <input
                            type="checkbox"
                            name="MBKM"
                            value="1"
                            class="w-5 h-5"
                            @checked(old('MBKM', $penawaran->MBKM))
                        >
                    </div>
                </div>

                {{-- KETERANGAN --}}
                <div class="col-span-2">
                    <label class="text-sm text-gray-400">
                        Keterangan
                    </label>

                    <input
                        type="text"
                        name="keterangan"
                        value="{{ old('keterangan', $penawaran->keterangan) }}"
                        class="w-full p-2 mt-1 bg-gray-700 rounded"
                    >
                </div>

            </div>

            <div class="flex justify-end gap-2 mt-6">

                <a
                    href="{{ route('penawaran.index') }}"
                    class="px-4 py-2 bg-gray-600 rounded hover:bg-gray-500"
                >
                    Batal
                </a>

                <button
                    type="submit"
                    class="px-4 py-2 bg-yellow-600 rounded hover:bg-yellow-500"
                >
                    Update
                </button>

            </div>

        </form>

    </div>

</div>
</x-layout>

<script>
    const sesiSelect = document.getElementById('sesi');
    const mkSelect = document.getElementById('kodemk');
    const mulaiSelect = document.getElementById('mulaipukul');
    const selesaiHidden = document.getElementById('selesaipukul_hidden');
    const selesaiInput = document.getElementById('selesaipukul');

    const jamPagi = @json($jamSlotsPagi);
    const jamMalam = @json($jamSlotsMalam);

    const currentMulai =
        "{{ \Carbon\Carbon::parse($penawaran->mulaipukul)->format('H:i') }}";

    function isiJam(slots) {

        mulaiSelect.innerHTML = '';

        slots.forEach(jam => {

            const selected =
                jam === currentMulai ? 'selected' : '';

            mulaiSelect.innerHTML += `
                <option value="${jam}" ${selected}>
                    ${jam}
                </option>
            `;
        });
    }

    function addMinutes(time, minutes) {

        const [hours, mins] = time.split(':').map(Number);

        const total = hours * 60 + mins + minutes;

        const newHours = Math.floor(total / 60);
        const newMins = total % 60;

        return String(newHours).padStart(2, '0')
            + ':'
            + String(newMins).padStart(2, '0');
    }

    function hitungSelesai() {

        const selectedOption =
            mkSelect.options[mkSelect.selectedIndex];

        const sks =
            parseInt(selectedOption.dataset.sks || 0);

        const jamMulai =
            mulaiSelect.value;

        if (!sks || !jamMulai) {

            selesaiInput.value = '';
            return;
        }

        const durasiMenit = sks * 50;

        selesaiInput.value =
            addMinutes(jamMulai, durasiMenit);
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