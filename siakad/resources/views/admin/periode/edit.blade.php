<x-layout>

    <div class="p-6">

       <a class="join-item btn btn-primary mb-4" href="{{ route('periode.index') }}">
        ⮜ Previous page
    </a>
        <form action="{{ route('periode.update', $periode->id) }}" method="POST">
            @csrf
            @method('PATCH')
            <fieldset class="fieldset bg-base-200 border border-base-300 rounded-box w-full max-w-xl mx-auto p-6">

                <legend class="fieldset-legend text-lg font-bold">
                    Edit Periode
                </legend>

                <label class="label font-bold">
                    Tahun Ajaran
                </label>
                <input
                    type="text"
                    name="tahun_ajaran"
                    maxlength="9"
                    value="{{old('tahun_ajaran', $periode->tahun_ajaran)}}"
                    class="input input-bordered w-full"
                />
                <x-forms.error name="tahun_ajaran"/>

                <label class="label font-bold">
                    Tanggal Mulai
                </label>
                <input
                    type="date"
                    name="tanggal_mulai"
                    placeholder="YYYY-MM-DD"
                    value="{{old('tanggal_mulai', $periode->tanggal_mulai)}}"
                    class="input input-bordered w-full"
                />
                <x-forms.error name="tanggal_mulai"/>

                <label class="label font-bold">
                    Tanggal Selesai
                </label>
                <input
                        type="date"
                        name="tanggal_selesai"
                        placeholder="YYYY-MM-DD"
                        value="{{old('tanggal_selesai', $periode->tanggal_selesai)}}"
                        class="input input-bordered w-full"
                />
                <x-forms.error name="tanggal_selesai"/>

              

                <button class="btn btn-primary mt-6">
                    Edit Periode
                </button>

            </fieldset>

        </form>

    </div>

</x-layout>