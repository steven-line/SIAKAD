<x-layout>
    <a class="join-item btn btn-primary mb-4" href="{{ url()->previous() }}">
        ⮜ Previous page
    </a>

    <form action="{{ route('nilai.update_bobot', ['mk' => $mk->kodemk]) }}" method="POST">
        @csrf
        @method('PATCH')
        <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-full border p-6 mx-auto max-w-4xl">
            <legend class="fieldset-legend font-bold text-lg">
                Tambah KRS
            </legend>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

             
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


                {{-- NILAI LAIN --}}
                <div>
                    <label class="label font-bold" for="lain">Nilai Lain</label>
                    <input type="number" step="0.01" class="input w-full" name="lain"
                        value="{{ old('lain') }}" />
                    <x-forms.error name="lain" />
                </div>

            </div>

            <button class="btn btn-primary mt-6 w-full">
                Ubah Bobot
            </button>

        </fieldset>
    </form>
</x-layout>