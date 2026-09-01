<x-layout>

    {{-- ========================================================= --}}
    {{-- FLASH MESSAGE --}}
    {{-- ========================================================= --}}

    @if (session('success'))
        <div class="alert alert-success mb-4">
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-error mb-4">
            <span>{{ session('error') }}</span>
        </div>
    @endif

    {{-- ========================================================= --}}
    {{-- VALIDATION ERROR --}}
    {{-- ========================================================= --}}

    @if ($errors->any())
        <div class="alert alert-error mb-4">
            <div>
                <p class="font-bold">Gagal menyimpan nilai:</p>

                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif


    <a
        class="join-item btn btn-primary mb-4"
        href="{{ url()->previous() }}"
    >
        ⮜ Previous page
    </a>


    {{-- ========================================================= --}}
    {{-- INFO MK --}}
    {{-- ========================================================= --}}

    <div class="alert alert-info mb-4">
        <div>
            <div class="font-bold">
                {{ $mk->nama }}
            </div>

            <div class="text-sm">
                Kode MK:
                <span class="font-medium">
                    {{ $mk->kodemk }}
                </span>

                <span class="mx-1">•</span>

                Jenis:
                <span class="font-medium">
                    {{ ucfirst($mk->jenis) }}
                </span>
            </div>

            {{-- INFO KHUSUS --}}
            @if ($isKhusus)

                @if ($mkKhususDiizinkan)
                    <div class="text-sm mt-2 text-success font-semibold">
                        ✓ Input UTS dan UAS mata kuliah khusus sedang diaktifkan Admin.
                    </div>
                @else
                    <div class="text-sm mt-2 text-error font-semibold">
                        ✕ Input UTS dan UAS mata kuliah khusus belum diaktifkan Admin.
                    </div>
                @endif

            @endif
        </div>
    </div>


    {{-- ========================================================= --}}
    {{-- FORM --}}
    {{-- ========================================================= --}}

    <form
        action="{{ route('nilai.update', [
            'mahasiswa' => $mahasiswa->nrp,
            'penawaran' => $penawaran->recno,
        ]) }}"
        method="POST"
    >

        @csrf
        @method('PATCH')


        <fieldset
            class="fieldset bg-base-200 border-base-300 rounded-box
                   w-full border p-6 mx-auto max-w-4xl"
        >

            <legend class="fieldset-legend font-bold text-lg">
                Edit Nilai Mahasiswa
            </legend>


            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">


                {{-- ================================================= --}}
                {{-- KELAS --}}
                {{-- ================================================= --}}

                <div>
                    <label class="label font-bold">
                        Kelas
                    </label>

                    <select
                        class="select select-bordered w-full"
                        name="kelas"
                        required
                    >
                        <option
                            value="A"
                            @selected(old('kelas', $krs->kelas) == 'A')
                        >
                            A
                        </option>

                        <option
                            value="B"
                            @selected(old('kelas', $krs->kelas) == 'B')
                        >
                            B
                        </option>

                        <option
                            value="C"
                            @selected(old('kelas', $krs->kelas) == 'C')
                        >
                            C
                        </option>
                    </select>

                    <x-forms.error name="kelas" />
                </div>


                {{-- ================================================= --}}
                {{-- BU --}}
                {{-- ================================================= --}}

                <div>
                    <label class="label font-bold">
                        BU
                    </label>

                    <input
                        type="text"
                        name="bu"
                        maxlength="1"
                        class="input w-full"
                        value="{{ old('bu', $krs->bu) }}"
                    >

                    <x-forms.error name="bu" />
                </div>


                {{-- ================================================= --}}
                {{-- UTS --}}
                {{-- ================================================= --}}

                <div>

                    <label class="label font-bold">
                        UTS
                    </label>

                    <input
                        type="number"
                        step="0.01"
                        min="0"
                        max="100"
                        name="uts"
                        class="input w-full"
                        value="{{ old('uts', $krs->uts) }}"
                        {{ !$bolehInputUts ? 'readonly' : '' }}
                    >

                    @if ($isKhusus)

                        <small class="{{ $mkKhususDiizinkan ? 'text-success' : 'text-error' }}">
                            @if ($mkKhususDiizinkan)
                                Input UTS aktif karena MK khusus diaktifkan Admin.
                            @else
                                Input UTS tidak aktif karena MK khusus belum diaktifkan Admin.
                            @endif
                        </small>

                    @else

                        <small class="text-gray-500">
                            @if ($bolehInputUts)
                                Periode input UTS sedang aktif.
                            @else
                                Di luar periode input UTS.
                            @endif
                        </small>

                    @endif

                    <x-forms.error name="uts" />

                </div>


                {{-- ================================================= --}}
                {{-- UAS --}}
                {{-- ================================================= --}}

                <div>

                    <label class="label font-bold">
                        UAS
                    </label>

                    <input
                        type="number"
                        step="0.01"
                        min="0"
                        max="100"
                        name="uas"
                        class="input w-full"
                        value="{{ old('uas', $krs->uas) }}"
                        {{ !$bolehInputUas ? 'readonly' : '' }}
                    >

                    @if ($isKhusus)

                        <small class="{{ $mkKhususDiizinkan ? 'text-success' : 'text-error' }}">
                            @if ($mkKhususDiizinkan)
                                Input UAS aktif karena MK khusus diaktifkan Admin.
                            @else
                                Input UAS tidak aktif karena MK khusus belum diaktifkan Admin.
                            @endif
                        </small>

                    @else

                        <small class="text-gray-500">
                            @if ($bolehInputUas)
                                Periode input UAS sedang aktif.
                            @else
                                Di luar periode input UAS.
                            @endif
                        </small>

                    @endif

                    <x-forms.error name="uas" />

                </div>


                {{-- ================================================= --}}
                {{-- TTT1 --}}
                {{-- ================================================= --}}

                <div>

                    <label class="label font-bold">
                        TTT1
                    </label>

                    <input
                        type="number"
                        step="0.01"
                        min="0"
                        max="100"
                        name="ttt1"
                        class="input w-full"
                        value="{{ old('ttt1', $krs->ttt1) }}"
                    >

                    <x-forms.error name="ttt1" />

                </div>


                {{-- ================================================= --}}
                {{-- TTT2 --}}
                {{-- ================================================= --}}

                <div>

                    <label class="label font-bold">
                        TTT2
                    </label>

                    <input
                        type="number"
                        step="0.01"
                        min="0"
                        max="100"
                        name="ttt2"
                        class="input w-full"
                        value="{{ old('ttt2', $krs->ttt2) }}"
                    >

                    <x-forms.error name="ttt2" />

                </div>


                {{-- ================================================= --}}
                {{-- NILAI LAIN --}}
                {{-- ================================================= --}}

                <div>

                    <label class="label font-bold">
                        Nilai Lain
                    </label>

                    <input
                        type="number"
                        step="0.01"
                        min="0"
                        max="100"
                        name="lain"
                        class="input w-full"
                        value="{{ old('lain', $krs->lain) }}"
                    >

                    <x-forms.error name="lain" />

                </div>


                {{-- ================================================= --}}
                {{-- NILAI AKHIR --}}
                {{-- ================================================= --}}

                <div>

                    <label class="label font-bold">
                        Nilai Akhir
                    </label>

                    <input
                        type="text"
                        class="input w-full"
                        value="{{ $krs->na }}"
                        readonly
                    >

                    <small class="text-gray-500">
                        Nilai dihitung otomatis berdasarkan bobot.
                    </small>

                </div>


                {{-- ================================================= --}}
                {{-- SURVEY --}}
                {{-- ================================================= --}}

                <div>

                    <label class="label font-bold">
                        Survey
                    </label>

                    <select
                        class="select select-bordered w-full"
                        name="survey"
                    >

                        <option
                            value="0"
                            @selected(old('survey', $krs->survey) == 0)
                        >
                            Belum
                        </option>

                        <option
                            value="1"
                            @selected(old('survey', $krs->survey) == 1)
                        >
                            Sudah
                        </option>

                    </select>

                    <x-forms.error name="survey" />

                </div>

            </div>


            {{-- ========================================================= --}}
            {{-- SIMPAN --}}
            {{-- ========================================================= --}}

            <button
                type="submit"
                class="btn btn-warning mt-6 w-full"
            >
                Update Nilai
            </button>

        </fieldset>

    </form>

</x-layout>
