<x-layout>

<div class="p-6">

    @if(session('success'))
        <div role="alert" class="alert alert-success mb-4">
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div role="alert" class="alert alert-error mb-4">
            <span>{{ session('error') }}</span>
        </div>
    @endif

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

                <input type="hidden" name="periode_id" value="{{ $periode->id }}">

                @php
                    $semesterAktif = $periode->semesters
                        ? $periode->semesters->where('aktif', 1)->first()
                        : null;
                @endphp

                <input type="text"
                       value="{{ $periode->tahun_ajaran }} - {{ $semesterAktif?->jenis ?? 'Tidak ada semester aktif' }}"
                       class="input input-bordered w-full"
                       readonly>

                <x-forms.error name="periode_id"/>

                @if($semesterAktif)
                    <input type="hidden" name="semester_id[]" value="{{ $semesterAktif->id }}">
                @endif

            @else

                <div role="alert" class="alert alert-error">
                    <span>Tidak ada periode aktif.</span>
                </div>

            @endif


            <div class="divider divider-primary">Periode Input Penawaran</div>

            <label class="label font-bold">Input Penawaran Mulai</label>
            <input type="datetime-local"
                   name="input_penawaran_mulai"
                   value="{{ old('input_penawaran_mulai', $metaperiode?->input_penawaran_mulai ? $metaperiode->input_penawaran_mulai->format('Y-m-d\TH:i') : '') }}"
                   class="input input-bordered w-full"/>
            <x-forms.error name="input_penawaran_mulai"/>

            <label class="label font-bold">Input Penawaran Selesai</label>
            <input type="datetime-local"
                   name="input_penawaran_selesai"
                   value="{{ old('input_penawaran_selesai', $metaperiode?->input_penawaran_selesai ? $metaperiode->input_penawaran_selesai->format('Y-m-d\TH:i') : '') }}"
                   class="input input-bordered w-full"/>
            <x-forms.error name="input_penawaran_selesai"/>


            <div class="divider divider-primary">Periode KRS</div>

            <label class="label font-bold">KRS Mulai</label>
            <input type="datetime-local"
                   name="krs_mulai"
                   value="{{ old('krs_mulai', $metaperiode?->krs_mulai ? $metaperiode->krs_mulai->format('Y-m-d\TH:i') : '') }}"
                   class="input input-bordered w-full"/>
            <x-forms.error name="krs_mulai"/>

            <label class="label font-bold">KRS Selesai</label>
            <input type="datetime-local"
                   name="krs_selesai"
                   value="{{ old('krs_selesai', $metaperiode?->krs_selesai ? $metaperiode->krs_selesai->format('Y-m-d\TH:i') : '') }}"
                   class="input input-bordered w-full"/>
            <x-forms.error name="krs_selesai"/>


            <div class="divider divider-primary">Input Nilai UTS</div>

            <label class="label font-bold">Input Nilai UTS Mulai</label>
            <input type="datetime-local"
                   name="input_nilai_uts_mulai"
                   value="{{ old('input_nilai_uts_mulai', $metaperiode?->input_nilai_uts_mulai ? $metaperiode->input_nilai_uts_mulai->format('Y-m-d\TH:i') : '') }}"
                   class="input input-bordered w-full"/>
            <x-forms.error name="input_nilai_uts_mulai"/>

            <label class="label font-bold">Input Nilai UTS Selesai</label>
            <input type="datetime-local"
                   name="input_nilai_uts_selesai"
                   value="{{ old('input_nilai_uts_selesai', $metaperiode?->input_nilai_uts_selesai ? $metaperiode->input_nilai_uts_selesai->format('Y-m-d\TH:i') : '') }}"
                   class="input input-bordered w-full"/>
            <x-forms.error name="input_nilai_uts_selesai"/>


            <div class="divider divider-primary">Input Nilai UAS</div>

            <label class="label font-bold">Input Nilai UAS Mulai</label>
            <input type="datetime-local"
                   name="input_nilai_uas_mulai"
                   value="{{ old('input_nilai_uas_mulai', $metaperiode?->input_nilai_uas_mulai ? $metaperiode->input_nilai_uas_mulai->format('Y-m-d\TH:i') : '') }}"
                   class="input input-bordered w-full"/>
            <x-forms.error name="input_nilai_uas_mulai"/>

            <label class="label font-bold">Input Nilai UAS Selesai</label>
            <input type="datetime-local"
                   name="input_nilai_uas_selesai"
                   value="{{ old('input_nilai_uas_selesai', $metaperiode?->input_nilai_uas_selesai ? $metaperiode->input_nilai_uas_selesai->format('Y-m-d\TH:i') : '') }}"
                   class="input input-bordered w-full"/>
            <x-forms.error name="input_nilai_uas_selesai"/>


            <div class="divider divider-primary">Pengumuman Nilai Final</div>

            <label class="label font-bold">Pengumuman Nilai Final Mulai</label>
            <input type="datetime-local"
                   name="pengumuman_nilai_final_mulai"
                   value="{{ old('pengumuman_nilai_final_mulai', $metaperiode?->pengumuman_nilai_final_mulai ? $metaperiode->pengumuman_nilai_final_mulai->format('Y-m-d\TH:i') : '') }}"
                   class="input input-bordered w-full"/>
            <x-forms.error name="pengumuman_nilai_final_mulai"/>

            <label class="label font-bold">Pengumuman Nilai Final Selesai</label>
            <input type="datetime-local"
                   name="pengumuman_nilai_final_selesai"
                   value="{{ old('pengumuman_nilai_final_selesai', $metaperiode?->pengumuman_nilai_final_selesai ? $metaperiode->pengumuman_nilai_final_selesai->format('Y-m-d\TH:i') : '') }}"
                   class="input input-bordered w-full"/>
            <x-forms.error name="pengumuman_nilai_final_selesai"/>

            <button class="btn btn-primary mt-6 w-full" {{ !$periode ? 'disabled' : '' }}>
                Simpan
            </button>

        </fieldset>

    </form>

</div>

</x-layout>