<x-layout>

    {{-- PREVIOUS --}}
    <a class="btn btn-primary"
       href="{{ route('mk.index') }}">
        ⮜ Previous page
    </a>


    {{-- FORM --}}
    <form class="flex h-screen"
          action="{{ route('mk.update', $mk->kodemk) }}"
          method="POST">

        @csrf
        @method('PATCH')

        <fieldset class="fieldset bg-base-200 border-base-300 rounded-box h-100 border p-6 mx-auto mt-10">

            {{-- IDENTITAS MK --}}
            <div class="grid grid-cols-3 gap-4">

                {{-- KODE MK --}}
                <div>
                    <label class="label font-bold">
                        KodeMk
                    </label>

                    <input
                        type="text"
                        class="input"
                        name="kodemk"
                        value="{{ old('kodemk', $mk->kodemk) }}"
                        maxlength="8"
                    />

                    <x-forms.error name="kodemk"/>
                </div>


                {{-- NAMA --}}
                <div>
                    <label class="label font-bold">
                        Nama
                    </label>

                    <input
                        type="text"
                        class="input"
                        name="nama"
                        value="{{ old('nama', $mk->nama) }}"
                        maxlength="50"
                    />

                    <x-forms.error name="nama"/>
                </div>


                {{-- SKS --}}
                <div>
                    <label class="label font-bold">
                        SKS
                    </label>

                    <input
                        type="text"
                        class="input"
                        name="sks"
                        value="{{ old('sks', $mk->sks) }}"
                        maxlength="3"
                    />

                    <x-forms.error name="sks"/>
                </div>

            </div>


            {{-- DATA TAMBAHAN --}}
            <div class="grid grid-cols-4 gap-4 mt-4">

                {{-- JENJANG --}}
                <div>
                    <label class="label font-bold">
                        Nama Jenjang Didik
                    </label>

                    <input
                        type="text"
                        class="input"
                        name="nm_jenj_didik"
                        value="{{ old('nm_jenj_didik', $mk->nm_jenj_didik) }}"
                        maxlength="2"
                    />

                    <x-forms.error name="nm_jenj_didik"/>
                </div>


                {{-- KURIKULUM --}}
                <div>
                    <label class="label font-bold">
                        Kurikulum
                    </label>

                    <select
                        class="select select-bordered w-full"
                        name="kode_kurikulum"
                        required
                    >

                        <option disabled
                            {{ old('kode_kurikulum', $mk->kode_kurikulum) ? '' : 'selected' }}>
                            Select Kurikulum
                        </option>

                        @foreach ($kurikulums as $kurikulum)

                            <option
                                value="{{ $kurikulum->kode_kurikulum }}"
                                @selected(
                                    old('kode_kurikulum', $mk->kode_kurikulum)
                                    == $kurikulum->kode_kurikulum
                                )
                            >
                                {{ $kurikulum->kode_kurikulum }}
                                - {{ $kurikulum->nama_kurikulum }}
                            </option>

                        @endforeach

                    </select>

                    <x-forms.error name="kode_kurikulum"/>
                </div>


                {{-- PRASYARAT SKS --}}
                <div>
                    <label class="label font-bold">
                        Prasyarat SKS
                    </label>

                    <input
                        type="text"
                        class="input"
                        name="prasyaratsks"
                        maxlength="3"
                        value="{{ old('prasyaratsks', $mk->prasyaratsks) }}"
                    />

                    <x-forms.error name="prasyaratsks"/>
                </div>


                {{-- PERIODE INPUT --}}
                <div>
                    <label class="label font-bold">
                        Periode Input
                    </label>

                    <select
                        class="select select-bordered w-full"
                        name="periode_input"
                        required
                    >

                        <option disabled
                            {{ old('periode_input', $mk->periode_input) ? '' : 'selected' }}>
                            Select Periode Input
                        </option>

                        <option
                            value="normal"
                            @selected(
                                old('periode_input', $mk->periode_input) === 'normal'
                            )
                        >
                            Normal
                        </option>

                        <option
                            value="khusus"
                            @selected(
                                old('periode_input', $mk->periode_input) === 'khusus'
                            )
                        >
                            Khusus
                        </option>

                    </select>

                    <x-forms.error name="periode_input"/>
                </div>

            </div>


            {{-- JENIS MATA KULIAH --}}
            <div class="grid grid-cols-4 gap-4 mt-4">

                <div>
                    <label class="label font-bold">
                        Jenis Mata Kuliah
                    </label>

                    <select
                        class="select select-bordered w-full"
                        name="jenis_mk"
                        required
                    >

                        <option disabled
                            {{ old('jenis_mk', $mk->jenis_mk) ? '' : 'selected' }}>
                            Select Jenis Mata Kuliah
                        </option>

                        <option
                            value="mk_fakultas"
                            @selected(
                                old('jenis_mk', $mk->jenis_mk) === 'mk_fakultas'
                            )
                        >
                            MK Fakultas
                        </option>

                        <option
                            value="mk_umum"
                            @selected(
                                old('jenis_mk', $mk->jenis_mk) === 'mk_umum'
                            )
                        >
                            MK Umum
                        </option>

                        <option
                            value="mk_prodi"
                            @selected(
                                old('jenis_mk', $mk->jenis_mk) === 'mk_prodi'
                            )
                        >
                            MK Prodi
                        </option>

                        <option
                            value="mk_khusus"
                            @selected(
                                old('jenis_mk', $mk->jenis_mk) === 'mk_khusus'
                            )
                        >
                            MK Khusus
                        </option>

                    </select>

                    <x-forms.error name="jenis_mk"/>
                </div>

            </div>


            {{-- PRASYARAT 1 - 10 --}}
            <div class="grid grid-cols-4 gap-4 mt-4">

                @for ($i = 1; $i <= 10; $i++)

                    <div>

                        <label class="label font-bold">
                            Prasyarat {{ $i }}
                        </label>

                        <select
                            class="select select-bordered w-full"
                            name="prasyarat{{ $i }}"
                        >

                            <option
                                value="-"
                                @selected(
                                    old(
                                        "prasyarat$i",
                                        $mk->{'prasyarat'.$i}
                                    ) == '-'
                                )
                            >
                                -- Tidak Ada Prasyarat --
                            </option>

                            @foreach ($mks as $matkul)

                                @if ($matkul->kodemk != $mk->kodemk)

                                    <option
                                        value="{{ $matkul->kodemk }}"
                                        @selected(
                                            old(
                                                "prasyarat$i",
                                                $mk->{'prasyarat'.$i}
                                            ) == $matkul->kodemk
                                        )
                                    >
                                        {{ $matkul->kodemk }}
                                        - {{ $matkul->nama }}
                                    </option>

                                @endif

                            @endforeach

                        </select>

                        <x-forms.error name="prasyarat{{ $i }}"/>

                    </div>

                @endfor

            </div>


            {{-- GRADE & AKTIF --}}
            <div class="grid grid-cols-4 gap-4 mt-4">

                {{-- PRASYARAT GRADE --}}
                <div>

                    <label class="label font-bold">
                        Prasyarat Grade
                    </label>

                    <select
                        class="select select-bordered w-full"
                        name="prasyaratgrade"
                    >

                        <option
                            value="-"
                            @selected(
                                old(
                                    'prasyaratgrade',
                                    $mk->prasyaratgrade
                                ) == '-'
                            )
                        >
                            -- Tidak Ada Prasyarat Grade --
                        </option>

                        <option
                            value="A"
                            @selected(
                                old(
                                    'prasyaratgrade',
                                    $mk->prasyaratgrade
                                ) == 'A'
                            )
                        >
                            A
                        </option>

                        <option
                            value="AB"
                            @selected(
                                old(
                                    'prasyaratgrade',
                                    $mk->prasyaratgrade
                                ) == 'AB'
                            )
                        >
                            AB
                        </option>

                        <option
                            value="B"
                            @selected(
                                old(
                                    'prasyaratgrade',
                                    $mk->prasyaratgrade
                                ) == 'B'
                            )
                        >
                            B
                        </option>

                        <option
                            value="BC"
                            @selected(
                                old(
                                    'prasyaratgrade',
                                    $mk->prasyaratgrade
                                ) == 'BC'
                            )
                        >
                            BC
                        </option>

                        <option
                            value="C"
                            @selected(
                                old(
                                    'prasyaratgrade',
                                    $mk->prasyaratgrade
                                ) == 'C'
                            )
                        >
                            C
                        </option>

                    </select>

                    <x-forms.error name="prasyaratgrade"/>

                </div>


                {{-- AKTIF --}}
                <div>

                    <label class="label font-bold">
                        Aktif
                    </label>

                    <input
                        type="checkbox"
                        class="checkbox"
                        name="aktif"
                        value="1"
                        @checked(old('aktif', $mk->aktif))
                    />

                    <x-forms.error name="aktif"/>

                </div>

            </div>


            {{-- SUBMIT --}}
            <button class="btn btn-primary mt-4">
                Edit Mata Kuliah
            </button>

        </fieldset>

    </form>

</x-layout>