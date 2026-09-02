<x-layout title="Tambah Penawaran Mata Kuliah Umum">

<div class="p-6 text-base-content max-w-5xl mx-auto">

    <h1 class="text-2xl font-bold text-center mb-6">
        Tambah Penawaran Mata Kuliah Umum
    </h1>

    <!-- Banner Informasi Kompatibel Light/Dark Mode -->
    <div class="alert alert-info rounded-lg mb-6 shadow-sm">
        <svg xmlns="http://w3.org" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <div>
            <strong class="block font-bold">Informasi</strong>
            <span class="text-sm opacity-90">Halaman ini digunakan Admin untuk membuat penawaran mata kuliah umum. Penawaran yang dibuat di sini akan digunakan oleh seluruh program studi.</span>
        </div>
    </div>

    <!-- Wrapper Form Utama Adaptif -->
    <div class="bg-base-100 border border-base-300 rounded-lg shadow-lg p-6">

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

        <form method="POST" action="{{ route('admin.penawaran.store') }}">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                {{-- Mata Kuliah --}}
                <div>
                    <label class="label">
                        <span class="label-text font-semibold text-base-content">
                            Mata Kuliah
                        </span>
                    </label>

                    <select name="kodemk"
                            id="kodemk"
                            class="select select-bordered w-full bg-base-100 text-base-content focus:select-primary">
                        @foreach($matkuls as $mk)
                            <option value="{{ $mk->kodemk }}" data-sks="{{ $mk->sks }}">
                                {{ $mk->kodemk }} - {{ $mk->nama }} ({{ $mk->sks }} SKS)
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Dosen --}}
                <div>
                    <label class="label">
                        <span class="label-text font-semibold text-base-content">
                            Dosen
                        </span>
                    </label>

                    <select name="dosen"
                            class="select select-bordered w-full bg-base-100 text-base-content focus:select-primary">
                        @foreach($dosens as $dsn)
                            <option value="{{ $dsn->nim_dosen }}">
                                {{ $dsn->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Semester --}}
                <div>
                    <label class="label">
                        <span class="label-text font-semibold text-base-content">
                            Semester
                        </span>
                    </label>

                    <select name="semester_id"
                            class="select select-bordered w-full bg-base-100 text-base-content focus:select-primary">
                        @forelse($semesters as $semester)
                            <option value="{{ $semester->id }}">
                                {{ $semester->nama }} - {{ $semester->periode->tahun_ajaran }} - {{ $semester->jenis }}
                            </option>
                        @empty
                            <option disabled selected>
                                Tidak ada semester aktif
                            </option>
                        @endforelse
                    </select>
                </div>

                {{-- Hari --}}
                <div>
                    <label class="label">
                        <span class="label-text font-semibold text-base-content">
                            Hari
                        </span>
                    </label>

                    <select name="hari"
                            class="select select-bordered w-full bg-base-100 text-base-content focus:select-primary">
                        <option>Senin</option>
                        <option>Selasa</option>
                        <option>Rabu</option>
                        <option>Kamis</option>
                        <option>Jumat</option>
                        <option>Sabtu</option>
                    </select>
                </div>

                {{-- Sesi --}}
                <div>
                    <label class="label">
                        <span class="label-text font-semibold text-base-content">
                            Sesi
                        </span>
                    </label>

                    <select name="sesi"
                            id="sesi"
                            class="select select-bordered w-full bg-base-100 text-base-content focus:select-primary">
                        <option value="1">Sesi 1 (Pagi)</option>
                        <option value="2">Sesi 2 (Malam)</option>
                    </select>
                </div>

                {{-- Jam Mulai --}}
                <div>
                    <label class="label">
                        <span class="label-text font-semibold text-base-content">
                            Jam Mulai
                        </span>
                    </label>

                    <select name="mulaipukul"
                            id="mulaipukul"
                            class="select select-bordered w-full bg-base-100 text-base-content focus:select-primary">
                    </select>
                </div>

                {{-- Jam Selesai --}}
                <div>
                    <label class="label">
                        <span class="label-text font-semibold text-base-content">
                            Jam Selesai
                        </span>
                    </label>

                    <input
                        id="selesaipukul"
                        type="text"
                        class="input input-bordered w-full bg-base-200 text-base-content/70 cursor-not-allowed"
                        readonly>

                    <input
                        type="hidden"
                        name="selesaipukul"
                        id="selesaipukul_hidden">
                </div>

                {{-- Jenis --}}
                <div>
                    <label class="label">
                        <span class="label-text font-semibold text-base-content">
                            Jenis Penawaran
                        </span>
                    </label>

                    <input
                        type="text"
                        value="Mata Kuliah Umum"
                        class="input input-bordered w-full bg-base-200 text-base-content/70 cursor-not-allowed"
                        readonly>
                </div>

                {{-- Kelas --}}
                <div>
                    <label class="label">
                        <span class="label-text font-semibold text-base-content">
                            Kelas
                        </span>
                    </label>

                    <select name="pataum"
                            class="select select-bordered w-full bg-base-100 text-base-content focus:select-primary">
                        <option value="P">Pagi</option>
                        <option value="M">Malam</option>
                    </select>
                </div>

                {{-- Pagu --}}
                <div>
                    <label class="label">
                        <span class="label-text font-semibold text-base-content">
                            Pagu
                        </span>
                    </label>

                    <input
                        type="number"
                        name="pagu"
                        min="1"
                        max="99"
                        class="input input-bordered w-full bg-base-100 text-base-content focus:input-primary"
                        required>
                </div>

                <!-- Bagian Penutup Form & Tombol Submit yang Utuh -->
                <div class="md:col-span-2 mt-4 flex justify-end">
                    <button type="submit" class="btn btn-primary px-8 shadow-md">
                        Simpan Penawaran
                    </button>
                </div>

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

function isiJam(slots){

    mulaiSelect.innerHTML='';

    slots.forEach(j=>{

        mulaiSelect.innerHTML += `<option value="${j}">${j}</option>`;

    });

}

function addMinutes(time, minutes){

    const [h,m]=time.split(':').map(Number);

    const total=h*60+m+minutes;

    return String(Math.floor(total/60)).padStart(2,'0')
            +':'
            +String(total%60).padStart(2,'0');

}

function hitung(){

    const sks=parseInt(
        mkSelect.options[mkSelect.selectedIndex].dataset.sks
    );

    const jam=mulaiSelect.value;

    if(!sks || !jam){

        selesaiInput.value='';
        selesaiHidden.value='';
        return;

    }

    const selesai=addMinutes(jam,sks*50);

    selesaiInput.value=selesai;
    selesaiHidden.value=selesai;

}

function updateJam(){

    isiJam(
        sesiSelect.value==2
        ? jamMalam
        : jamPagi
    );

    hitung();

}

sesiSelect.addEventListener('change',updateJam);
mkSelect.addEventListener('change',hitung);
mulaiSelect.addEventListener('change',hitung);

updateJam();

</script>

</x-layout>