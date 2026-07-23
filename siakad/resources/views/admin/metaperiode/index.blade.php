<x-layout>

<div class="p-6">

    <form action="{{ route('metaperiode.update') }}" method="POST">
        @csrf
        @method('PATCH')

        <fieldset class="fieldset bg-base-200 border border-base-300 rounded-box w-full max-w-xl mx-auto p-6">

            <legend class="fieldset-legend text-lg font-bold">
                Edit Meta Periode
            </legend>

            @if($periode)

                {{-- ================= PERIODE ================= --}}
                <label class="label font-bold">Periode</label>

                {{-- VALUE ASLI --}}
                <input type="hidden" name="periode_id" value="{{ $periode->id }}">

                @php
                    // ambil semester aktif (ganjil/genap)
                    $semesterAktif = $periode->semesters
                        ? $periode->semesters->where('aktif', 1)->first()
                        : null;
                @endphp

                {{-- TAMPILAN USER --}}
                <input type="text"
                       value="{{ $periode->tahun_ajaran }} - {{ $semesterAktif?->jenis ?? 'Tidak ada semester aktif' }}"
                       class="input input-bordered w-full"
                       readonly>

                <x-forms.error name="periode_id"/>

                {{-- KIRIM HANYA SEMESTER AKTIF --}}
                @if($semesterAktif)
                    <input type="hidden" name="semester_id[]" value="{{ $semesterAktif->id }}">
                @endif

            @else
                <div class="text-red-500">
                    Tidak ada periode aktif
                </div>
            @endif


            {{-- ================= KRS ================= --}}
            <label class="label font-bold mt-4">KRS Mulai</label>
            <input type="datetime-local" name="krs_mulai"
                value="{{ old('krs_mulai', $metaperiode?->krs_mulai ? \Carbon\Carbon::parse($metaperiode->krs_mulai)->format('Y-m-d\TH:i') : '') }}"
                class="input input-bordered w-full"/>
            <x-forms.error name="krs_mulai"/>

            <label class="label font-bold">KRS Selesai</label>
            <input type="datetime-local" name="krs_selesai"
                value="{{ old('krs_selesai', $metaperiode?->krs_selesai ? \Carbon\Carbon::parse($metaperiode->krs_selesai)->format('Y-m-d\TH:i') : '') }}"
                class="input input-bordered w-full"/>
            <x-forms.error name="krs_selesai"/>

            {{-- ================= INPUT NILAI ================= --}}
            <label class="label font-bold mt-4">Input Nilai UTS Mulai</label>
            <input type="datetime-local" name="input_nilai_uts_mulai"
                value="{{ old('input_nilai_uts_mulai', $metaperiode?->input_nilai_uts_mulai ? \Carbon\Carbon::parse($metaperiode->input_nilai_uts_mulai)->format('Y-m-d\TH:i') : '') }}"
                class="input input-bordered w-full"/>
            <x-forms.error name="input_nilai_uts_mulai"/>

            <label class="label font-bold">Input Nilai UTS Selesai</label>
            <input type="datetime-local" name="input_nilai_uts_selesai"
                value="{{ old('input_nilai_uts_selesai', $metaperiode?->input_nilai_uts_selesai ? \Carbon\Carbon::parse($metaperiode->input_nilai_uts_selesai)->format('Y-m-d\TH:i') : '') }}"
                class="input input-bordered w-full"/>
            <x-forms.error name="input_nilai_uts_selesai"/>

            <label class="label font-bold mt-4">Input Nilai UAS Mulai</label>
            <input type="datetime-local" name="input_nilai_uas_mulai"
                value="{{ old('input_nilai_uas_mulai', $metaperiode?->input_nilai_uas_mulai ? \Carbon\Carbon::parse($metaperiode->input_nilai_uas_mulai)->format('Y-m-d\TH:i') : '') }}"
                class="input input-bordered w-full"/>
            <x-forms.error name="input_nilai_uas_mulai"/>

            <label class="label font-bold">Input Nilai UAS Selesai</label>
            <input type="datetime-local" name="input_nilai_uas_selesai"
                value="{{ old('input_nilai_uas_selesai', $metaperiode?->input_nilai_uas_selesai ? \Carbon\Carbon::parse($metaperiode->input_nilai_uas_selesai)->format('Y-m-d\TH:i') : '') }}"
                class="input input-bordered w-full"/>
            <x-forms.error name="input_nilai_uas_selesai"/>
    
            {{-- ================= pengumuman nilai final ================= --}}
            <label class="label font-bold mt-4">Pengumuman Nilai Final Mulai</label>
            <input type="datetime-local" name="pengumuman_nilai_final_mulai"
                value="{{ old('pengumuman_nilai_final_mulai', $metaperiode?->pengumuman_nilai_final_mulai ? \Carbon\Carbon::parse($metaperiode->pengumuman_nilai_final_mulai)->format('Y-m-d\TH:i') : '') }}"
                class="input input-bordered w-full"/>
            <x-forms.error name="pengumuman_nilai_final_mulai"/>

            <label class="label font-bold">Pengumuman Nilai Final Selesai</label>
            <input type="datetime-local" name="pengumuman_nilai_final_selesai"
                value="{{ old('pengumuman_nilai_final_selesai', $metaperiode?->pengumuman_nilai_final_selesai ? \Carbon\Carbon::parse($metaperiode->pengumuman_nilai_final_selesai)->format('Y-m-d\TH:i') : '') }}"
                class="input input-bordered w-full"/>
            <x-forms.error name="pengumuman_nilai_final_selesai"/>

            <button class="btn btn-primary mt-6 w-full">
                Simpan
            </button>

        </fieldset>

    </form>

</div>

</x-layout>