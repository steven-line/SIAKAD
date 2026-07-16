<x-layout>

    <div class="p-6">

       <a class="join-item btn btn-primary mb-4" href="{{ route('periode.index') }}">
        ⮜ Previous page
    </a>
        <form action="{{ route('periode.store') }}" method="POST">
            @csrf

            <fieldset class="fieldset bg-base-200 border border-base-300 rounded-box w-full max-w-xl mx-auto p-6">

                <legend class="fieldset-legend text-lg font-bold">
                    Tambah Periode
                </legend>

                <label class="label font-bold">
                    Tahun Ajaran
                </label>
                <input
                    type="text"
                    name="tahun_ajaran"
                    maxlength="9"
                    value="{{ old('tahun_ajaran') }}"
                    class="input input-bordered w-full"
                    placeholder="contoh: 2023/2024"
                />
                <x-forms.error name="tahun_ajaran"/>

                <label class="label font-bold">
                    Tanggal Mulai
                </label>
                <input
                    type="date"
                    name="tanggal_mulai"
                    placeholder="YYYY-MM-DD"
                    value="{{old('tanggal_mulai', date('Y-m-d'))}}"
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
                        value="{{old('tanggal_selesai', date('Y-m-d'))}}"
                        class="input input-bordered w-full"
                />
                <x-forms.error name="tanggal_selesai"/>

              

                <button class="btn btn-primary mt-6">
                    Buat Periode
                </button>

            </fieldset>

        </form>

    </div>

</x-layout>