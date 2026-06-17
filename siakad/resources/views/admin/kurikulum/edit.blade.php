<x-layout>

    <div class="p-6">

      
       <a class="join-item btn btn-primary mb-4" href="{{ url()->previous() }}">
        ⮜ Previous page
    </a>

        <form
            action="{{ route('kurikulum.store', $kurikulum->kode_kurikulum) }}"
            method="POST"
        >
            @csrf
            @method('PATCH')

            <fieldset class="fieldset bg-base-200 border border-base-300 rounded-box w-full max-w-xl mx-auto p-6">

                <legend class="fieldset-legend text-lg font-bold">
                    Edit Kurikulum
                </legend>

                {{-- Kode Kurikulum --}}
                <label class="label font-bold">
                    Kode Kurikulum
                </label>
                <input
                    type="text"
                    name="kode_kurikulum"
                    value="{{ old('kode_kurikulum', $kurikulum->kode_kurikulum) }}"
                    class="input input-bordered w-full"
                />
                <x-forms.error name="kode_kurikulum"/>

                {{-- Nama Kurikulum --}}
                <label class="label font-bold">
                    Nama Kurikulum
                </label>
                <input
                    type="text"
                    name="nama_kurikulum"
                    value="{{ old('nama_kurikulum', $kurikulum->nama_kurikulum) }}"
                    class="input input-bordered w-full"
                />
                <x-forms.error name="nama_kurikulum"/>

                {{-- Aktif --}}
                <label class="label font-bold">
                    Aktif
                </label>
                <input
                    type="checkbox"
                    name="aktif"
                    class="checkbox"
                    @checked(old('aktif', $kurikulum->aktif))
                />
                <x-forms.error name="aktif"/>

                {{-- Deskripsi --}}
                <label class="label font-bold">
                    Deskripsi
                </label>
                <textarea
                    name="deskripsi"
                    class="textarea textarea-bordered w-full min-h-32"
                >{{ old('deskripsi', $kurikulum->deskripsi) }}</textarea>
                <x-forms.error name="deskripsi"/>

                {{-- Tahun Mulai --}}
                <label class="label font-bold">
                    Tahun Mulai Berlaku
                </label>
                <input
                    type="number"
                    name="tahun_mulai_berlaku"
                    min="2000"
                    max="2100"
                    value="{{ old('tahun_mulai_berlaku', $kurikulum->tahun_mulai_berlaku) }}"
                    class="input input-bordered w-full"
                    oninput="checkNumberFieldLength(this)"
                />
                <x-forms.error name="tahun_mulai_berlaku"/>

                {{-- Tahun Selesai --}}
                <label class="label font-bold">
                    Tahun Selesai Berlaku
                </label>
                <input
                    type="number"
                    name="tahun_selesai_berlaku"
                    min="2000"
                    max="2100"
                    value="{{ old('tahun_selesai_berlaku', $kurikulum->tahun_selesai_berlaku) }}"
                    class="input input-bordered w-full"
                    oninput="checkNumberFieldLength(this)"
                />
                <x-forms.error name="tahun_selesai_berlaku"/>

                <button class="btn btn-warning mt-6">
                    Simpan Perubahan
                </button>

            </fieldset>

        </form>

    </div>

</x-layout>

<script>
function checkNumberFieldLength(elem) {
    if (elem.value.length > 4) {
        elem.value = elem.value.slice(0, 4);
    }
}
</script>