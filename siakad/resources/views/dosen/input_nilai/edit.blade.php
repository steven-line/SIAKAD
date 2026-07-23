    <x-layout>
        <a class="join-item btn btn-primary mb-4" href="{{ url()->previous() }}">
            ⮜ Previous page
        </a>

        <form action="{{ route('nilai.update', [
            'mahasiswa' => $mahasiswa->nrp,
            'mk' => $mk->kodemk,
        ]) }}" method="POST">
            @csrf
            @method('PATCH')

            <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-full border p-6 mx-auto max-w-4xl">
                <legend class="fieldset-legend font-bold text-lg">
                    Edit Nilai Mahasiswa
                </legend>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    {{-- Kelas --}}
                    <div>
                        <label class="label font-bold">Kelas</label>

                        <select class="select select-bordered w-full" name="kelas" required>
                            <option value="A" @selected(old('kelas', $krs->kelas) == 'A')>A</option>
                            <option value="B" @selected(old('kelas', $krs->kelas) == 'B')>B</option>
                            <option value="C" @selected(old('kelas', $krs->kelas) == 'C')>C</option>
                        </select>

                        <x-forms.error name="kelas" />
                    </div>

                

                    {{-- BU --}}
                    <div>
                        <label class="label font-bold">BU</label>

                        <input
                            type="text"
                            name="bu"
                            maxlength="1"
                            class="input w-full"
                            value="{{ old('bu', $krs->bu) }}"
                        >

                        <x-forms.error name="bu" />
                    </div>

                    {{-- UTS --}}
                    <div>
                        <label class="label font-bold">UTS</label>

                        <input
                            type="number"
                            step="0.01"
                            name="uts"
                            class="input w-full"
                            value="{{ old('uts', $krs->uts) }}"
                             {{ (now()->gte($periodeInputNilai->input_nilai_uts_mulai) && now()->lte($periodeInputNilai->input_nilai_uts_selesai)) ? '' : 'readonly' }}
                       
                            >

                        <x-forms.error name="uts" />
                    </div>

                    {{-- UAS --}}
                    <div>
                        <label class="label font-bold">UAS</label>

                        <input
                            type="number"
                            step="0.01"
                            name="uas"
                            class="input w-full"
                            value="{{ old('uas', $krs->uas) }}"
                             {{ (now()->gte($periodeInputNilai->input_nilai_uas_mulai) && now()->lte($periodeInputNilai->input_nilai_uas_selesai)) ? '' : 'readonly' }}
                        >

                        <x-forms.error name="uas" />
                    </div>

                    {{-- TTT1 --}}
                    <div>
                        <label class="label font-bold">TTT1</label>

                        <input
                            type="number"
                            step="0.01"
                            name="ttt1"
                            class="input w-full"
                            value="{{ old('ttt1', $krs->ttt1) }}"
                        >

                        <x-forms.error name="ttt1" />
                    </div>

                    {{-- TTT2 --}}
                    <div>
                        <label class="label font-bold">TTT2</label>

                        <input
                            type="number"
                            step="0.01"
                            name="ttt2"
                            class="input w-full"
                            value="{{ old('ttt2', $krs->ttt2) }}"
                        >

                        <x-forms.error name="ttt2" />
                    </div>

        
                    {{-- Nilai Lain --}}
                    <div>
                        <label class="label font-bold">Nilai Lain</label>

                        <input
                            type="number"
                            step="0.01"
                            name="lain"
                            class="input w-full"
                            value="{{ old('lain', $krs->lain) }}"
                        >

                        <x-forms.error name="lain" />
                    </div>

                   {{-- Nilai Akhir (AUTO) --}}
                <div>
                    <label class="label font-bold">Nilai Akhir</label>

                    <input
                        type="text"
                        class="input w-full"
                        value="{{ $krs->na }}"
                        readonly
                    >

                    <small class="text-gray-500">
                        Nilai dihitung otomatis berdasarkan bobot
                    </small>
                </div>
                                    {{-- Survey --}}
                    <div>
                        <label class="label font-bold">Survey</label>

                        <select class="select select-bordered w-full" name="survey">
                            <option value="0" @selected(old('survey', $krs->survey) == 0)>
                                Belum
                            </option>

                            <option value="1" @selected(old('survey', $krs->survey) == 1)>
                                Sudah
                            </option>
                        </select>

                        <x-forms.error name="survey" />
                    </div>

                </div>

                <button class="btn btn-warning mt-6 w-full">
                    Update Nilai
                </button>

            </fieldset>
        </form>
    </x-layout>