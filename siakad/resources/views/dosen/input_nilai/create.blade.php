<x-layout>
    <a class="join-item btn btn-primary mb-4" href="{{ url()->previous() }}">
        ⮜ Previous page
    </a>

    <form action="{{ route('nilai.store', [
        'mahasiswa' => $mahasiswa->nrp,
        'mk' => $mk->kodemk,
    ]) }}" method="POST">
        @csrf

        <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-full border p-6 mx-auto max-w-4xl">
            <legend class="fieldset-legend font-bold text-lg">
                Tambah KRS
            </legend>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                {{-- KELAS --}}
                <div>
                    <label class="label font-bold">Kelas</label>

                    <select class="select select-bordered w-full" name="kelas" required>
                        <option disabled selected>Pilih Kelas</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                    </select>

                    <x-forms.error name="kelas" />
                </div>

                {{-- SEMESTER (READ ONLY) --}}
                <div>
                    <label class="label font-bold">Semester</label>

                    <input type="text" class="input w-full" disabled
                        value="{{ $semester->periode->tahun_ajaran ?? '-' }} - {{ $semester->jenis ?? '-' }}">
                </div>

                {{-- BU --}}
                <div>
                    <label class="label font-bold" for="bu">BU</label>
                    <input type="text" class="input w-full" name="bu"
                        value="{{ old('bu') }}" maxlength="1"
                        placeholder="Y / N" />
                    <x-forms.error name="bu" />
                </div>

                {{-- UTS --}}
                <div>
                    <label class="label font-bold" for="uts">UTS</label>
                    <input type="number" step="0.01" class="input w-full" name="uts"
                        value="{{ old('uts') }}" />
                    <x-forms.error name="uts" />
                </div>

                {{-- UAS --}}
                <div>
                    <label class="label font-bold" for="uas">UAS</label>
                    <input type="number" step="0.01" class="input w-full" name="uas"
                        value="{{ old('uas') }}" />
                    <x-forms.error name="uas" />
                </div>

                {{-- TTT1 --}}
                <div>
                    <label class="label font-bold" for="ttt1">TTT1</label>
                    <input type="number" step="0.01" class="input w-full" name="ttt1"
                        value="{{ old('ttt1') }}" />
                    <x-forms.error name="ttt1" />
                </div>

                {{-- TTT2 --}}
                <div>
                    <label class="label font-bold" for="ttt2">TTT2</label>
                    <input type="number" step="0.01" class="input w-full" name="ttt2"
                        value="{{ old('ttt2') }}" />
                    <x-forms.error name="ttt2" />
                </div>

                {{-- TTT3 --}}
                <div>
                    <label class="label font-bold" for="ttt3">TTT3</label>
                    <input type="number" step="0.01" class="input w-full" name="ttt3"
                        value="{{ old('ttt3') }}" />
                    <x-forms.error name="ttt3" />
                </div>

                {{-- NILAI LAIN --}}
                <div>
                    <label class="label font-bold" for="lain">Nilai Lain</label>
                    <input type="number" step="0.01" class="input w-full" name="lain"
                        value="{{ old('lain') }}" />
                    <x-forms.error name="lain" />
                </div>

                {{-- NA --}}
                <div>
                    <label class="label font-bold" for="na">Nilai Akhir</label>
                    <input type="text" class="input w-full" name="na"
                        value="{{ old('na') }}" maxlength="2"
                        placeholder="A / B / C" />
                    <x-forms.error name="na" />
                </div>

                {{-- SURVEY --}}
                <div>
                    <label class="label font-bold">Survey</label>

                    <select class="select select-bordered w-full" name="survey">
                        <option value="0">Belum</option>
                        <option value="1">Sudah</option>
                    </select>

                    <x-forms.error name="survey" />
                </div>

            </div>

            <button class="btn btn-primary mt-6 w-full">
                Simpan KRS
            </button>

        </fieldset>
    </form>
</x-layout>