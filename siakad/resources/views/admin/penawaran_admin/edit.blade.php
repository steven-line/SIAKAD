<x-layout title="Edit Penawaran Mata Kuliah Umum">

<div class="p-6 text-white max-w-5xl mx-auto">

    <h1 class="text-2xl font-bold text-center mb-6">
        Edit Penawaran Mata Kuliah Umum
    </h1>

    <div class="bg-yellow-600 p-4 rounded-lg mb-6">
        <strong>Informasi</strong><br>
        Halaman ini digunakan untuk mengubah penawaran mata kuliah umum.
        Perubahan akan berlaku untuk seluruh mahasiswa yang mengambil penawaran ini.
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

        <form method="POST"
              action="{{ route('admin.penawaran.update',$penawaran->recno) }}">

            @csrf
            @method('PATCH')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                {{-- Mata Kuliah --}}
                <div>

                    <label class="label">
                        <span class="label-text text-white">
                            Mata Kuliah
                        </span>
                    </label>

                    <select
                        name="kodemk"
                        id="kodemk"
                        class="select select-bordered w-full">

                        @foreach($matkuls as $mk)

                            <option
                                value="{{ $mk->kodemk }}"
                                data-sks="{{ $mk->sks }}"
                                {{ old('kodemk',$penawaran->kodemk)==$mk->kodemk ? 'selected' : '' }}>

                                {{ $mk->kodemk }}
                                -
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

                    <select
                        name="dosen"
                        class="select select-bordered w-full">

                        @foreach($dosens as $dsn)

                            <option
                                value="{{ $dsn->nim_dosen }}"
                                {{ old('dosen',$penawaran->dosen)==$dsn->nim_dosen ? 'selected' : '' }}>

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

                    <select
                        name="semester_id"
                        class="select select-bordered w-full">

                        @foreach($semesters as $semester)

                            <option
                                value="{{ $semester->id }}"
                                {{ old('semester_id',$penawaran->semester_id)==$semester->id ? 'selected' : '' }}>

                                {{ $semester->nama }}
                                -
                                {{ $semester->periode->tahun_ajaran }}
                                -
                                {{ $semester->jenis }}

                            </option>

                        @endforeach

                    </select>

                </div>

                {{-- Hari --}}
                <div>

                    <label class="label">
                        <span class="label-text text-white">
                            Hari
                        </span>
                    </label>

                    <select
                        name="hari"
                        class="select select-bordered w-full">

                        @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'] as $hari)

                            <option
                                value="{{ $hari }}"
                                {{ old('hari',$penawaran->hari)==$hari ? 'selected' : '' }}>

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

                    <select
                        name="sesi"
                        id="sesi"
                        class="select select-bordered w-full">

                        <option value="1"
                            {{ old('sesi',$penawaran->sesi)=='1' ? 'selected' : '' }}>
                            Sesi 1 (Pagi)
                        </option>

                        <option value="2"
                            {{ old('sesi',$penawaran->sesi)=='2' ? 'selected' : '' }}>
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

                    <select
                        name="mulaipukul"
                        id="mulaipukul"
                        class="select select-bordered w-full">
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
                        type="text"
                        id="selesaipukul"
                        class="input input-bordered w-full"
                        readonly>

                    <input
                        type="hidden"
                        name="selesaipukul"
                        id="selesaipukul_hidden">

                </div>


                {{-- Jenis Kelas --}}
                <div>

                    <label class="label">
                        <span class="label-text text-white">
                            Jenis Kelas
                        </span>
                    </label>

                    <select
                        name="pataum"
                        class="select select-bordered w-full">

                        <option value="P"
                            {{ old('pataum',$penawaran->pataum)=='P' ? 'selected' : '' }}>
                            Pagi
                        </option>

                        <option value="M"
                            {{ old('pataum',$penawaran->pataum)=='M' ? 'selected' : '' }}>
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
                        value="{{ old('pagu',$penawaran->pagu) }}"
                        class="input input-bordered w-full"
                        required>

                </div>


                {{-- MBKM --}}
                <div>

                    <label class="label cursor-pointer justify-start gap-3">

                        <input
                            type="checkbox"
                            name="MBKM"
                            value="1"
                            class="checkbox checkbox-primary"
                            {{ old('MBKM',$penawaran->MBKM) ? 'checked' : '' }}>

                        <span class="label-text text-white">
                            Mata Kuliah MBKM
                        </span>

                    </label>

                </div>


                {{-- Keterangan --}}
                <div class="md:col-span-2">

                    <label class="label">
                        <span class="label-text text-white">
                            Keterangan
                        </span>
                    </label>

                    <textarea
                        name="keterangan"
                        rows="3"
                        class="textarea textarea-bordered w-full">{{ old('keterangan',$penawaran->keterangan) }}</textarea>

                </div>

            </div>

            <div class="flex justify-between mt-8">

                <a href="{{ route('admin.penawaran.index') }}"
                   class="btn btn-neutral">
                    ← Kembali
                </a>

                <button
                    type="submit"
                    class="btn btn-warning">

                    Update Penawaran

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
const selesaiHidden = document.getElementById('selesaipukul_hidden');

const jamPagi = @json($jamSlotsPagi);
const jamMalam = @json($jamSlotsMalam);

// jam yang tersimpan di database
const oldMulai = "{{ old('mulaipukul', optional($penawaran->mulaipukul)->format('H:i')) }}";

function isiJam(slots){

    mulaiSelect.innerHTML = '';

    slots.forEach(function(jam){

        const option = document.createElement('option');

        option.value = jam;
        option.textContent = jam;

        if(jam === oldMulai){
            option.selected = true;
        }

        mulaiSelect.appendChild(option);

    });

}

function addMinutes(time, minutes){

    const [h,m] = time.split(':').map(Number);

    const total = h * 60 + m + minutes;

    const jam = String(Math.floor(total / 60)).padStart(2,'0');
    const menit = String(total % 60).padStart(2,'0');

    return jam + ':' + menit;

}

function hitung(){

    if(mulaiSelect.selectedIndex < 0){
        return;
    }

    const sks = parseInt(
        mkSelect.options[mkSelect.selectedIndex].dataset.sks
    );

    const jam = mulaiSelect.value;

    if(!sks || !jam){

        selesaiInput.value = "";
        selesaiHidden.value = "";

        return;

    }

    const selesai = addMinutes(jam, sks * 50);

    selesaiInput.value = selesai;
    selesaiHidden.value = selesai;

}

function updateJam(){

    if(sesiSelect.value == "2"){
        isiJam(jamMalam);
    }else{
        isiJam(jamPagi);
    }

    hitung();

}

sesiSelect.addEventListener('change', updateJam);
mkSelect.addEventListener('change', hitung);
mulaiSelect.addEventListener('change', hitung);

updateJam();

</script>

</x-layout>