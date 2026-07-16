<x-layout>
    <div class="p-6">

        <a class="join-item btn btn-primary mb-4" href="{{ route('jurusan.index') }}">
            ⮜ Previous page
        </a>

        <form class="flex"
              action="{{ route('jurusan.store') }}"
              method="POST">
            @csrf

            <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-full max-w-xl border p-6 mx-auto">

                <legend class="fieldset-legend text-lg font-bold">
                    Tambah Jurusan
                </legend>

                <label class="label font-bold" for="kode_jurusan">Kode Jurusan</label>
                <input
                    type="text"
                    maxlength="3"
                    value="{{ old('kode_jurusan') }}"
                    class="input input-bordered w-full"
                    name="kode_jurusan"
                    placeholder=""
                />
                <x-forms.error name="kode_jurusan"/>

                <label class="label font-bold mt-3" for="nama_jurusan">Nama Jurusan</label>
                <input
                    type="text"
                    maxlength="50"
                    value="{{ old('nama_jurusan') }}"
                    class="input input-bordered w-full"
                    name="nama_jurusan"
                    placeholder=""
                />
                <x-forms.error name="nama_jurusan"/>

                <label class="label font-bold mt-3" for="program_pendidikan">Program Pendidikan</label>
                <input
                    type="text"
                    maxlength="50"
                    value="{{ old('program_pendidikan') }}"
                    class="input input-bordered w-full"
                    name="program_pendidikan"
                    placeholder=""
                />
                <x-forms.error name="program_pendidikan"/>

                <label class="label font-bold mt-3" for="sk_ban">SK BAN</label>
                <input
                    type="text"
                    maxlength="50"
                    value="{{ old('sk_ban') }}"
                    class="input input-bordered w-full"
                    name="sk_ban"
                    placeholder=""
                />
                <x-forms.error name="sk_ban"/>

                <label class="label font-bold mt-3" for="keterangan">Keterangan</label>
                <textarea
                    name="keterangan"
                    maxlength="255"
                    class="textarea textarea-bordered w-full min-h-28"
                >{{ old('keterangan') }}</textarea>
                <x-forms.error name="keterangan"/>

                <label class="label font-bold mt-3" for="kode_fakultas">Fakultas</label>
                <select class="select select-bordered w-full" name="kode_fakultas" required>
                    <option disabled {{ old('kode_fakultas') ? '' : 'selected' }}>Pilih Fakultas</option>
                    @foreach ($fakultass as $fakultas)
                        <option value="{{ $fakultas->kode_fakultas }}" {{ old('kode_fakultas') == $fakultas->kode_fakultas ? 'selected' : '' }}>
                            {{ $fakultas->nama_fakultas }}
                        </option>
                    @endforeach
                </select>
                <x-forms.error name="kode_fakultas  "/>

                <button class="btn btn-primary mt-6">
                    Buat Jurusan
                </button>

            </fieldset>
        </form>
    </div>
</x-layout>