<x-layout>

    <div class="p-6">

        <a class="join-item btn btn-primary mb-4" href="{{ route('kurikulum.index') }}">
            ⮜ Previous page
        </a>

        <form action="{{ route('kurikulum.store') }}" method="POST">
            @csrf

            <fieldset class="fieldset bg-base-200 border border-base-300 rounded-box w-full max-w-xl mx-auto p-6">

                <legend class="fieldset-legend text-lg font-bold">
                    Tambah Kurikulum
                </legend>

                <label class="label font-bold">
                    Kode Kurikulum
                </label>
                <input
                    type="text"
                    name="kode_kurikulum"
                    maxlength="15"
                    class="input input-bordered w-full"
                    value="{{ old('kode_kurikulum') }}"
                />
                <x-forms.error name="kode_kurikulum"/>

                <label class="label font-bold">
                    Nama Kurikulum
                </label>
                <input
                    type="text"
                    name="nama_kurikulum"
                    maxlength="50"
                    class="input input-bordered w-full"
                    value="{{ old('nama_kurikulum') }}"
                />
                <x-forms.error name="nama_kurikulum"/>

                <label class="label font-bold mt-2" for="kode_prodi">
                    Kode Prodi
                </label>
                <select class="select select-bordered w-full" name="kode_prodi" required>
                    <option disabled {{ old('kode_prodi') ? '' : 'selected' }}>Pilih Prodi</option>
                    @foreach ($prodis as $prodi)
                        <option value="{{ $prodi->kode_prodi }}" {{ old('kode_prodi') == $prodi->kode_prodi ? 'selected' : '' }}>
                            {{ $prodi->kode_prodi }}
                        </option>
                    @endforeach
                </select>
                <x-forms.error name="kode_prodi"/>

                <label class="label font-bold">
                    Aktif
                </label>
                <input
                    type="checkbox"
                    name="aktif"
                    class="checkbox"
                    {{ old('aktif') ? 'checked' : '' }}
                />
                <x-forms.error name="aktif"/>

                <label class="label font-bold">
                    Deskripsi
                </label>
                <textarea
                    name="deskripsi"
                    maxlength="255"
                    class="textarea textarea-bordered w-full min-h-32"
                >{{ old('deskripsi') }}</textarea>
                <x-forms.error name="deskripsi"/>

                <label class="label font-bold">
                    Tahun Mulai Berlaku
                </label>
                <input
                    type="number"
                    name="tahun_mulai_berlaku"
                    min="2000"
                    max="3000"
                    class="input input-bordered w-full"
                    value="{{ old('tahun_mulai_berlaku') }}"
                />
                <x-forms.error name="tahun_mulai_berlaku"/>

                <label class="label font-bold">
                    Tahun Selesai Berlaku
                </label>
                <input
                    type="number"
                    name="tahun_selesai_berlaku"
                    min="2000"
                    max="3000"
                    class="input input-bordered w-full"
                    value="{{ old('tahun_selesai_berlaku') }}"
                />
                <x-forms.error name="tahun_selesai_berlaku"/>

                <button class="btn btn-primary mt-6">
                    Buat Kurikulum
                </button>

            </fieldset>

        </form>

    </div>

</x-layout>

<script>
  function checkNumberFieldLength(elem){
    if (elem.value.length > 4) {
        elem.value = elem.value.slice(0,4); 
    }
}
</script>