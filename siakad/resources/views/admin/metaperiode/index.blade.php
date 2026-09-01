<x-layout title="Master Setting Periode">

<div class="p-6">

```
{{-- ========================================================= --}}
{{-- FLASH MESSAGE --}}
{{-- ========================================================= --}}

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

{{-- ========================================================= --}}
{{-- VALIDATION ERROR --}}
{{-- ========================================================= --}}

@if($errors->any())
    <div role="alert" class="alert alert-error mb-4">
        <div>
            <ul>
                @foreach($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

{{-- ========================================================= --}}
{{-- FORM --}}
{{-- ========================================================= --}}

<form action="{{ route('metaperiode.update') }}" method="POST">

    @csrf
    @method('PATCH')

    <fieldset
        class="fieldset bg-base-200 border border-base-300 rounded-box
               w-full max-w-3xl mx-auto p-6"
    >

        <legend class="fieldset-legend text-xl font-bold">
            Master Setting Periode
        </legend>

        {{-- ================================================= --}}
        {{-- PERIODE AKTIF --}}
        {{-- ================================================= --}}

        @if($periode)

            <div class="divider divider-primary">
                Periode Aktif
            </div>

            <label class="label font-bold">
                Periode
            </label>

            <input
                type="hidden"
                name="periode_id"
                value="{{ $periode->id }}"
            >

            @php
                $semesterAktif = $periode->semesters
                    ->where('aktif', 1)
                    ->first();
            @endphp

            <input
                type="text"
                value="{{ $periode->tahun_ajaran }} -
                       {{ $semesterAktif?->jenis ?? 'Tidak ada semester aktif' }}"
                class="input input-bordered w-full"
                readonly
            >

            <x-forms.error name="periode_id"/>

        @else

            <div role="alert" class="alert alert-error">
                <span>
                    Tidak ada periode aktif.
                </span>
            </div>

        @endif


        {{-- ================================================= --}}
        {{-- INPUT PENAWARAN --}}
        {{-- ================================================= --}}

        <div class="divider divider-primary">
            Periode Input Penawaran
        </div>

        <label class="label font-bold">
            Input Penawaran Mulai
        </label>

        <input
            type="datetime-local"
            name="input_penawaran_mulai"
            value="{{ old(
                'input_penawaran_mulai',
                $metaperiode?->input_penawaran_mulai
                    ? $metaperiode->input_penawaran_mulai->format('Y-m-d\TH:i')
                    : ''
            ) }}"
            class="input input-bordered w-full"
        >

        <x-forms.error name="input_penawaran_mulai"/>


        <label class="label font-bold">
            Input Penawaran Selesai
        </label>

        <input
            type="datetime-local"
            name="input_penawaran_selesai"
            value="{{ old(
                'input_penawaran_selesai',
                $metaperiode?->input_penawaran_selesai
                    ? $metaperiode->input_penawaran_selesai->format('Y-m-d\TH:i')
                    : ''
            ) }}"
            class="input input-bordered w-full"
        >

        <x-forms.error name="input_penawaran_selesai"/>


        {{-- ================================================= --}}
        {{-- KRS --}}
        {{-- ================================================= --}}

        <div class="divider divider-primary">
            Periode KRS
        </div>

        <label class="label font-bold">
            KRS Mulai
        </label>

        <input
            type="datetime-local"
            name="krs_mulai"
            value="{{ old(
                'krs_mulai',
                $metaperiode?->krs_mulai
                    ? $metaperiode->krs_mulai->format('Y-m-d\TH:i')
                    : ''
            ) }}"
            class="input input-bordered w-full"
        >

        <x-forms.error name="krs_mulai"/>


        <label class="label font-bold">
            KRS Selesai
        </label>

        <input
            type="datetime-local"
            name="krs_selesai"
            value="{{ old(
                'krs_selesai',
                $metaperiode?->krs_selesai
                    ? $metaperiode->krs_selesai->format('Y-m-d\TH:i')
                    : ''
            ) }}"
            class="input input-bordered w-full"
        >

        <x-forms.error name="krs_selesai"/>


        {{-- ================================================= --}}
        {{-- INPUT NILAI UTS --}}
        {{-- ================================================= --}}

        <div class="divider divider-primary">
            Periode Input Nilai UTS
        </div>

        <label class="label font-bold">
            Input Nilai UTS Mulai
        </label>

        <input
            type="datetime-local"
            name="input_nilai_uts_mulai"
            value="{{ old(
                'input_nilai_uts_mulai',
                $metaperiode?->input_nilai_uts_mulai
                    ? $metaperiode->input_nilai_uts_mulai->format('Y-m-d\TH:i')
                    : ''
            ) }}"
            class="input input-bordered w-full"
        >

        <x-forms.error name="input_nilai_uts_mulai"/>


        <label class="label font-bold">
            Input Nilai UTS Selesai
        </label>

        <input
            type="datetime-local"
            name="input_nilai_uts_selesai"
            value="{{ old(
                'input_nilai_uts_selesai',
                $metaperiode?->input_nilai_uts_selesai
                    ? $metaperiode->input_nilai_uts_selesai->format('Y-m-d\TH:i')
                    : ''
            ) }}"
            class="input input-bordered w-full"
        >

        <x-forms.error name="input_nilai_uts_selesai"/>


        {{-- ================================================= --}}
        {{-- INPUT NILAI UAS --}}
        {{-- ================================================= --}}

        <div class="divider divider-primary">
            Periode Input Nilai UAS
        </div>

        <label class="label font-bold">
            Input Nilai UAS Mulai
        </label>

        <input
            type="datetime-local"
            name="input_nilai_uas_mulai"
            value="{{ old(
                'input_nilai_uas_mulai',
                $metaperiode?->input_nilai_uas_mulai
                    ? $metaperiode->input_nilai_uas_mulai->format('Y-m-d\TH:i')
                    : ''
            ) }}"
            class="input input-bordered w-full"
        >

        <x-forms.error name="input_nilai_uas_mulai"/>


        <label class="label font-bold">
            Input Nilai UAS Selesai
        </label>

        <input
            type="datetime-local"
            name="input_nilai_uas_selesai"
            value="{{ old(
                'input_nilai_uas_selesai',
                $metaperiode?->input_nilai_uas_selesai
                    ? $metaperiode->input_nilai_uas_selesai->format('Y-m-d\TH:i')
                    : ''
            ) }}"
            class="input input-bordered w-full"
        >

        <x-forms.error name="input_nilai_uas_selesai"/>


        {{-- ================================================= --}}
        {{-- MK KHUSUS --}}
        {{-- ================================================= --}}

        <div class="divider divider-primary">
            Input Nilai Mata Kuliah Khusus
        </div>

        <div class="alert alert-info mb-5">

            <div>

                <h3 class="font-bold">
                    Pengaturan Input Nilai Mata Kuliah Khusus
                </h3>

                <p class="text-sm mt-1">
                    Aktifkan toggle pada mata kuliah khusus agar
                    dosen dapat langsung menginput nilai UTS dan UAS
                    mata kuliah tersebut tanpa mengikuti periode
                    input nilai UTS/UAS umum.
                </p>

            </div>

        </div>


        @if(isset($mkKhusus) && $mkKhusus->count() > 0)

            <div class="space-y-3">

                @foreach($mkKhusus as $mk)

                    @php

                        /*
                         * Database menyimpan KODE MK.
                         * Contoh:
                         * ["TA001", "KKN001"]
                         */

                        $kodeMk = trim((string) $mk->kodemk);

                        $isAktif = in_array(
                            $kodeMk,
                            $mkKhususAktif ?? [],
                            true
                        );

                    @endphp


                    <div
                        class="flex items-center justify-between gap-4
                               bg-base-100 border border-base-300
                               rounded-box p-4"
                    >

                        {{-- INFO MK --}}

                        <div class="min-w-0">

                            <div class="font-bold">
                                {{ $mk->nama }}
                            </div>

                            <div class="text-sm opacity-70 mt-1">

                                Kode:

                                <span class="font-medium">
                                    {{ $mk->kodemk }}
                                </span>

                                @if(!empty($mk->jenis_khusus))

                                    <span class="mx-1">•</span>

                                    {{ $mk->jenis_khusus }}

                                @endif

                            </div>

                        </div>


                        {{-- TOGGLE --}}

                        <div class="flex items-center gap-3 shrink-0">

                            <span
                                class="text-sm font-medium"
                                id="status-{{ $mk->kodemk }}"
                            >
                                {{ $isAktif ? 'Aktif' : 'Tidak Aktif' }}
                            </span>


                            <input
                                type="checkbox"
                                name="mk_khusus[]"
                                value="{{ $kodeMk }}"
                                class="toggle toggle-primary mk-khusus-toggle"
                                data-status="status-{{ $mk->kodemk }}"
                                {{ $isAktif ? 'checked' : '' }}
                            >

                        </div>

                    </div>

                @endforeach

            </div>

        @else

            <div role="alert" class="alert alert-warning">

                <span>
                    Belum ada mata kuliah khusus yang terdeteksi.
                </span>

            </div>

        @endif


        {{-- ================================================= --}}
        {{-- PENGUMUMAN NILAI FINAL --}}
        {{-- ================================================= --}}

        <div class="divider divider-primary">
            Pengumuman Nilai Final
        </div>

        <label class="label font-bold">
            Pengumuman Nilai Final Mulai
        </label>

        <input
            type="datetime-local"
            name="pengumuman_nilai_final_mulai"
            value="{{ old(
                'pengumuman_nilai_final_mulai',
                $metaperiode?->pengumuman_nilai_final_mulai
                    ? $metaperiode->pengumuman_nilai_final_mulai->format('Y-m-d\TH:i')
                    : ''
            ) }}"
            class="input input-bordered w-full"
        >

        <x-forms.error name="pengumuman_nilai_final_mulai"/>


        <label class="label font-bold">
            Pengumuman Nilai Final Selesai
        </label>

        <input
            type="datetime-local"
            name="pengumuman_nilai_final_selesai"
            value="{{ old(
                'pengumuman_nilai_final_selesai',
                $metaperiode?->pengumuman_nilai_final_selesai
                    ? $metaperiode->pengumuman_nilai_final_selesai->format('Y-m-d\TH:i')
                    : ''
            ) }}"
            class="input input-bordered w-full"
        >

        <x-forms.error name="pengumuman_nilai_final_selesai"/>


        {{-- ================================================= --}}
        {{-- SIMPAN --}}
        {{-- ================================================= --}}

        <button
            type="submit"
            class="btn btn-primary mt-6 w-full"
            {{ !$periode ? 'disabled' : '' }}
        >
            Simpan Pengaturan
        </button>

    </fieldset>

</form>
```

</div>

{{-- ========================================================= --}}
{{-- SCRIPT TOGGLE --}}
{{-- ========================================================= --}}

<script>

document.addEventListener('DOMContentLoaded', function () {

    const toggles = document.querySelectorAll('.mk-khusus-toggle');

    toggles.forEach(function (toggle) {

        toggle.addEventListener('change', function () {

            const statusId = this.dataset.status;
            const status = document.getElementById(statusId);

            if (!status) {
                return;
            }

            if (this.checked) {
                status.textContent = 'Aktif';
            } else {
                status.textContent = 'Tidak Aktif';
            }

        });

    });

});

</script>

</x-layout>
