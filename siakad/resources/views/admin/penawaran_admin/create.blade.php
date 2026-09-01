<x-layout title="Tambah Penawaran Mata Kuliah Umum">

<div class="p-6 text-white max-w-5xl mx-auto">

```
<h1 class="text-2xl font-bold text-center mb-6">
    Tambah Penawaran Mata Kuliah Umum
</h1>

<div class="bg-blue-600 p-4 rounded-lg mb-6">
    <strong>Informasi</strong><br>
    Halaman ini digunakan Admin untuk membuat penawaran mata kuliah umum.
    Penawaran yang dibuat di sini akan digunakan oleh seluruh program studi.
</div>

<div class="bg-gray-800 rounded-lg shadow-lg p-6">

    @if ($errors->any())
        <div class="alert alert-error mb-5">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success mb-5">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error mb-5">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST"
          action="{{ route('admin.penawaran.store') }}">

        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

            {{-- Mata Kuliah --}}
            <div>

                <label class="label">
                    <span class="label-text text-white">
                        Mata Kuliah
                    </span>
                </label>

                <select name="kodemk"
                        id="kodemk"
                        class="select select-bordered w-full"
                        required>

                    <option value="" disabled
                        @selected(!old('kodemk'))>
                        Pilih Mata Kuliah
                    </option>

                    @foreach($matkuls as $mk)

                        <option value="{{ $mk->kodemk }}"
                                data-sks="{{ $mk->sks }}"
                                @selected(old('kodemk') == $mk->kodemk)>

                            {{ $mk->kodemk }} -
                            {{ $mk->nama }}
                            ({{ $mk->sks }} SKS)

                        </option>

                    @endforeach

                </select>

            </div>


            {{-- Dosen --}}
            <div>

                <label class="label">
                    <span class="label-text text-white">
                        Dosen
                    </span>
                </label>

                <select name="dosen"
                        class="select select-bordered w-full"
                        required>

                    <option value="" disabled
                        @selected(!old('dosen'))>
                        Pilih Dosen
                    </option>

                    @foreach($dosens as $dsn)

                        <option value="{{ $dsn->nim_dosen }}"
                                @selected(old('dosen') == $dsn->nim_dosen)>

                            {{ $dsn->nama }}

                        </option>

                    @endforeach

                </select>

            </div>


            {{-- Semester --}}
            <div>

                <label class="label">
                    <span class="label-text text-white">
                        Semester
                    </span>
                </label>

                <select name="semester_id"
                        class="select select-bordered w-full"
                        required>

                    <option value="" disabled
                        @selected(!old('semester_id'))>
                        Pilih Semester
                    </option>

                    @forelse($semesters as $semester)

                        <option value="{{ $semester->id }}"
                                @selected(old('semester_id') == $semester->id)>

                            {{ $semester->nama }}
                            -
                            {{ $semester->periode->tahun_ajaran }}
                            -
                            {{ $semester->jenis }}

                        </option>

                    @empty

                        <option disabled>
                            Tidak ada semester aktif
                        </option>

                    @endforelse

                </select>

            </div>


            {{-- Hari --}}
            <div>

                <label class="label">
                    <span class="label-text text-white">
                        Hari
                    </span>
                </label>

                <select name="hari"
                        class="select select-bordered w-full"
                        required>

                    @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $hari)

                        <option value="{{ $hari }}"
                            @selected(old('hari', 'Senin') == $hari)>

                            {{ $hari }}

                        </option>

                    @endforeach

                </select>

            </div>


            {{-- Sesi --}}
            <div>

                <label class="label">
                    <span class="label-text text-white">
                        Sesi
                    </span>
                </label>

                <select name="sesi"
                        id="sesi"
                        class="select select-bordered w-full"
                        required>

                    <option value="1"
                        @selected(old('sesi', '1') == '1')>
                        Sesi 1 (Pagi)
                    </option>

                    <option value="2"
                        @selected(old('sesi') == '2')>
                        Sesi 2 (Malam)
                    </option>

                </select>

            </div>


            {{-- Jam Mulai --}}
            <div>

                <label class="label">
                    <span class="label-text text-white">
                        Jam Mulai
                    </span>
                </label>

                <select name="mulaipukul"
                        id="mulaipukul"
                        class="select select-bordered w-full"
                        required>
                </select>

            </div>


            {{-- Jam Selesai --}}
            <div>

                <label class="label">
                    <span class="label-text text-white">
                        Jam Selesai
                    </span>
                </label>

                <input
                    id="selesaipukul"
                    type="text"
                    class="input input-bordered w-full"
                    readonly>

                <input
                    type="hidden"
                    name="selesaipukul"
                    id="selesaipukul_hidden">

            </div>


            {{-- Jenis Penawaran --}}
            <div>

                <label class="label">
                    <span class="label-text text-white">
                        Jenis Penawaran
                    </span>
                </label>

                <input
                    type="text"
                    value="Mata Kuliah Umum"
                    class="input input-bordered w-full"
                    readonly>

            </div>


            {{-- Kelas --}}
            <div>

                <label class="label">
                    <span class="label-text text-white">
                        Kelas
                    </span>
                </label>

                <select name="pataum"
                        class="select select-bordered w-full"
                        required>

                    <option value="P"
                        @selected(old('pataum', 'P') == 'P')>
                        Pagi
                    </option>

                    <option value="M"
                        @selected(old('pataum') == 'M')>
                        Malam
                    </option>

                </select>

            </div>


            {{-- Pagu --}}
            <div>

                <label class="label">
                    <span class="label-text text-white">
                        Pagu
                    </span>
                </label>

                <input
                    type="number"
                    name="pagu"
                    min="1"
                    max="99"
                    value="{{ old('pagu') }}"
                    class="input input-bordered w-full"
                    required>

            </div>


            {{-- MBKM --}}
            <div>

                <label class="label">
                    <span class="label-text text-white">
                        MBKM
                    </span>
                </label>

                <input
                    type="checkbox"
                    name="MBKM"
                    value="1"
                    class="checkbox checkbox-success"
                    @checked(old('MBKM'))>

            </div>


            {{-- Keterangan --}}
            <div class="md:col-span-2">

                <label class="label">
                    <span class="label-text text-white">
                        Keterangan
                    </span>
                </label>

                <input
                    type="text"
                    name="keterangan"
                    value="{{ old('keterangan') }}"
                    class="input input-bordered w-full">

            </div>

        </div>


        <div class="flex justify-between mt-8">

            <a href="{{ route('admin.penawaran.index') }}"
               class="btn btn-neutral">

                ← Kembali

            </a>

            <button type="submit"
                    class="btn btn-primary">

                Simpan Penawaran

            </button>

        </div>

    </form>

</div>
```

</div>

<script>

const sesiSelect = document.getElementById('sesi');
const mkSelect = document.getElementById('kodemk');
const mulaiSelect = document.getElementById('mulaipukul');

const selesaiInput = document.getElementById('selesaipukul');
const selesaiHidden = document.getElementById('selesaipukul_hidden');

const jamPagi = @json($jamSlotsPagi);
const jamMalam = @json($jamSlotsMalam);

const oldJamMulai = @json(old('mulaipukul'));


function isiJam(slots) {

    mulaiSelect.innerHTML = '';

    slots.forEach(j => {

        const option = document.createElement('option');

        option.value = j;
        option.textContent = j;

        if (j === oldJamMulai) {
            option.selected = true;
        }

        mulaiSelect.appendChild(option);

    });

}


function addMinutes(time, minutes) {

    const [h, m] = time.split(':').map(Number);

    const total = h * 60 + m + minutes;

    return String(Math.floor(total / 60)).padStart(2, '0')
        + ':'
        + String(total % 60).padStart(2, '0');

}


function hitung() {

    if (!mkSelect.value || !mulaiSelect.value) {

        selesaiInput.value = '';
        selesaiHidden.value = '';

        return;
    }

    const selectedOption =
        mkSelect.options[mkSelect.selectedIndex];

    const sks = parseInt(selectedOption.dataset.sks);

    const jam = mulaiSelect.value;

    if (!sks || !jam) {

        selesaiInput.value = '';
        selesaiHidden.value = '';

        return;
    }

    const selesai = addMinutes(jam, sks * 50);

    selesaiInput.value = selesai;
    selesaiHidden.value = selesai;

}


function updateJam() {

    const slots =
        sesiSelect.value == '2'
            ? jamMalam
            : jamPagi;

    isiJam(slots);

    hitung();

}


sesiSelect.addEventListener('change', updateJam);

mkSelect.addEventListener('change', hitung);

mulaiSelect.addEventListener('change', hitung);

updateJam();

</script>

</x-layout>
