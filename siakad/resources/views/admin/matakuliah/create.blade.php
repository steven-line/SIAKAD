<x-layout>

<a class="btn btn-primary" href="{{ route('mk.index') }}">
    ⮜ Previous page
</a>

<form class="flex h-screen" action="{{ route('mk.store') }}" method="POST">
    @csrf

    <fieldset class="fieldset bg-base-200 border-base-300 rounded-box h-100 border p-6 mx-auto mt-10">

        {{-- IDENTITAS MK --}}
        <div class="grid grid-cols-3 gap-4">

            <div>
                <label class="label font-bold" for="kodemk">
                    KodeMk
                </label>

                <input
                    type="text"
                    class="input"
                    name="kodemk"
                    value="{{ old('kodemk') }}"
                    placeholder="TF2028"
                    maxlength="8"
                />

                <x-forms.error name="kodemk"/>
            </div>


            <div>
                <label class="label font-bold" for="nama">
                    Nama
                </label>

                <input
                    type="text"
                    class="input"
                    name="nama"
                    maxlength="50"
                    placeholder="Aljabar Linear Matriks"
                    value="{{ old('nama') }}"
                />

                <x-forms.error name="nama"/>
            </div>


            <div>
                <label class="label font-bold" for="sks">
                    SKS
                </label>

                <input
                    type="text"
                    class="input"
                    name="sks"
                    maxlength="3"
                    value="{{ old('sks') }}"
                />

                <x-forms.error name="sks"/>
            </div>

        </div>


        {{-- DATA TAMBAHAN MK --}}
        <div class="grid grid-cols-4 gap-4 mt-4">

            <div>
                <label class="label font-bold" for="nm_jenj_didik">
                    Nama Jenjang Didik
                </label>

                <input
                    type="text"
                    class="input"
                    maxlength="2"
                    name="nm_jenj_didik"
                    value="{{ old('nm_jenj_didik') }}"
                />

                <x-forms.error name="nm_jenj_didik"/>
            </div>


            <div>
                <label class="label font-bold" for="kode_kurikulum">
                    Kurikulum
                </label>

                <select
                    class="select select-bordered w-full"
                    name="kode_kurikulum"
                    required
                >
                    <option disabled
                        {{ old('kode_kurikulum') ? '' : 'selected' }}>
                        Select Kurikulum
                    </option>

                    @foreach ($kurikulums as $kurikulum)

                        <option
                            value="{{ $kurikulum->kode_kurikulum }}"
                            @selected(
                                old('kode_kurikulum') == $kurikulum->kode_kurikulum
                            )
                        >
                            {{ $kurikulum->kode_kurikulum }}
                            - {{ $kurikulum->nama_kurikulum }}
                        </option>

                    @endforeach
                </select>

                <x-forms.error name="kode_kurikulum"/>
            </div>


            <div>
                <label class="label font-bold" for="prasyaratsks">
                    Prasyarat SKS
                </label>

                <input
                    type="text"
                    class="input"
                    name="prasyaratsks"
                    value="{{ old('prasyaratsks') }}"
                    maxlength="3"
                />

                <x-forms.error name="prasyaratsks"/>
            </div>


            {{-- PERIODE INPUT --}}
            <div>
                <label class="label font-bold" for="periode_input">
                    Periode Input
                </label>

                <select
                    class="select select-bordered w-full"
                    name="periode_input"
                    id="periode_input"
                    required
                >
                    <option disabled
                        {{ old('periode_input') ? '' : 'selected' }}>
                        Select Periode Input
                    </option>

                    <option
                        value="normal"
                        @selected(old('periode_input', 'normal') === 'normal')
                    >
                        Normal
                    </option>

                    <option
                        value="khusus"
                        @selected(old('periode_input') === 'khusus')
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
                <label class="label font-bold" for="jenis_mk">
                    Jenis Mata Kuliah
                </label>

                <select
                    class="select select-bordered w-full"
                    name="jenis_mk"
                    id="jenis_mk"
                    required
                >
                    <option disabled
                        {{ old('jenis_mk') ? '' : 'selected' }}>
                        Select Jenis Mata Kuliah
                    </option>

                    <option
                        value="mk_fakultas"
                        @selected(old('jenis_mk') === 'mk_fakultas')
                    >
                        MK Fakultas
                    </option>

                    <option
                        value="mk_umum"
                        @selected(old('jenis_mk') === 'mk_umum')
                    >
                        MK Umum
                    </option>

                    <option
                        value="mk_prodi"
                        @selected(old('jenis_mk', 'mk_prodi') === 'mk_prodi')
                    >
                        MK Prodi
                    </option>

                    <option
                        value="mk_khusus"
                        @selected(old('jenis_mk') === 'mk_khusus')
                    >
                        MK Khusus
                    </option>
                </select>

                <x-forms.error name="jenis_mk"/>
            </div>

        </div>


        {{-- PRASYARAT 1 - 4 --}}
        <div class="grid grid-cols-4 gap-4 mt-4">

            @for ($i = 1; $i <= 4; $i++)

                <div>

                    <label class="label font-bold">
                        Prasyarat {{ $i }}
                    </label>

                    <select
                        class="select select-bordered w-full"
                        name="prasyarat{{ $i }}"
                    >

                        <option selected value="-">
                            Select MK
                        </option>

                        @foreach ($mks as $mk)

                            <option
                                value="{{ $mk->kodemk }}"
                                @selected(
                                    old("prasyarat$i") == $mk->kodemk
                                )
                            >
                                {{ $mk->kodemk }} - {{ $mk->nama }}
                            </option>

                        @endforeach

                    </select>

                    <x-forms.error name="prasyarat{{ $i }}"/>

                </div>

            @endfor

        </div>


        {{-- PRASYARAT 5 - 8 --}}
        <div class="grid grid-cols-4 gap-4 mt-4">

            @for ($i = 5; $i <= 8; $i++)

                <div>

                    <label class="label font-bold">
                        Prasyarat {{ $i }}
                    </label>

                    <select
                        class="select select-bordered w-full"
                        name="prasyarat{{ $i }}"
                    >

                        <option selected value="-">
                            Select MK
                        </option>

                        @foreach ($mks as $mk)

                            <option
                                value="{{ $mk->kodemk }}"
                                @selected(
                                    old("prasyarat$i") == $mk->kodemk
                                )
                            >
                                {{ $mk->kodemk }} - {{ $mk->nama }}
                            </option>

                        @endforeach

                    </select>

                    <x-forms.error name="prasyarat{{ $i }}"/>

                </div>

            @endfor

        </div>


        {{-- PRASYARAT 9 - 10 --}}
        <div class="grid grid-cols-4 gap-4 mt-4">

            @for ($i = 9; $i <= 10; $i++)

                <div>

                    <label class="label font-bold">
                        Prasyarat {{ $i }}
                    </label>

                    <select
                        class="select select-bordered w-full"
                        name="prasyarat{{ $i }}"
                    >

                        <option selected value="-">
                            Select MK
                        </option>

                        @foreach ($mks as $mk)

                            <option
                                value="{{ $mk->kodemk }}"
                                @selected(
                                    old("prasyarat$i") == $mk->kodemk
                                )
                            >
                                {{ $mk->kodemk }} - {{ $mk->nama }}
                            </option>

                        @endforeach

                    </select>

                    <x-forms.error name="prasyarat{{ $i }}"/>

                </div>

            @endfor


            {{-- PRASYARAT GRADE --}}
            <div>

                <label class="label font-bold">
                    Prasyarat Grade
                </label>

                <select
                    class="select select-bordered w-full"
                    name="prasyaratgrade"
                    required
                >

                    <option disabled
                        {{ old('prasyaratgrade') ? '' : 'selected' }}>
                        Select Prasyarat Grade
                    </option>

                    <option
                        value="A"
                        @selected(old('prasyaratgrade') === 'A')
                    >
                        A
                    </option>

                    <option
                        value="AB"
                        @selected(old('prasyaratgrade') === 'AB')
                    >
                        AB
                    </option>

                    <option
                        value="B"
                        @selected(old('prasyaratgrade') === 'B')
                    >
                        B
                    </option>

                    <option
                        value="BC"
                        @selected(old('prasyaratgrade') === 'BC')
                    >
                        BC
                    </option>

                    <option
                        value="C"
                        @selected(old('prasyaratgrade') === 'C')
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
                    @checked(old('aktif'))
                />

            </div>

        </div>


        {{-- SUBMIT --}}
        <button class="btn btn-primary mt-4">
            Buat Mata Kuliah
        </button>

    </fieldset>

</form>

</x-layout>