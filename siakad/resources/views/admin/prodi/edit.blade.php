<x-layout>

    <div class="p-6">

        <a class="btn btn-primary mb-6" href="{{ route('prodi.index') }}">
            ⮜ Previous page
        </a>

        <form action="{{ route('prodi.update', $prodi->kode_prodi) }}" method="POST">
            @csrf
            @method('PATCH')

            <fieldset class="fieldset bg-base-200 border border-base-300 rounded-box w-full max-w-xl mx-auto p-6">

                <legend class="fieldset-legend text-lg font-bold">
                    Ubah Program Studi
                </legend>

                <label class="label font-bold" for="kode_prodi">
                    Kode Prodi
                </label>
                <input
                    type="text"
                    class="input input-bordered w-full"
                    name="kode_prodi"
                    maxlength="15"
                    value="{{ old('kode_prodi', $prodi->kode_prodi) }}"
                />
                <x-forms.error name="kode_prodi"/>

                <label class="label font-bold" for="nama_prodi">
                    Nama Prodi
                </label>
                <input
                    type="text"
                    class="input input-bordered w-full"
                    name="nama_prodi"
                    maxlength="50"
                    value="{{ old('nama_prodi', $prodi->nama_prodi) }}"
                />
                <x-forms.error name="nama_prodi"/>

                <label class="label font-bold mt-2" for="kode_fakultas">
                    Kode Fakultas
                </label>

                <select
                    class="select select-bordered w-full"
                    name="kode_fakultas"
                    required
                >
                    <option disabled>Pilih Fakultas</option>

                    @foreach ($fakultass as $fakultas)
                        <option
                            value="{{ $fakultas->kode_fakultas }}"
                            @selected(old('kode_fakultas', $prodi->kode_fakultas) == $fakultas->kode_fakultas)
                        >
                            {{ $fakultas->kode_fakultas }} - {{ $fakultas->nama_fakultas }}
                        </option>
                    @endforeach

                </select>

                <x-forms.error name="kode_fakultas"/>

                <button class="btn btn-primary mt-6">
                    Ubah Prodi
                </button>

            </fieldset>

        </form>

    </div>

</x-layout>