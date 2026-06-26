<x-layout>
<div class="p-6">

    <a class="join-item btn btn-primary" href="{{ route('prodi.index') }}">
        ⮜ Previous page
    </a>

    <form action="{{ route('prodi.store') }}" method="POST">
        @csrf

        <fieldset class="fieldset bg-base-200 border border-base-300 rounded-box w-full max-w-xl mx-auto p-6">

            <label class="label font-bold" for="kode_prodi">kode_prodi</label>
            <input type="text" class="input input-bordered w-full" maxlength="15" name="kode_prodi" placeholder="" value="{{ old('kode_prodi') }}"    />
            <x-forms.error name='kode_prodi'/>

            <label class="label font-bold" for="nama_prodi">nama_prodi</label>
            <input type="text" class="input input-bordered w-full" maxlength="50" name="nama_prodi" placeholder="" value="{{ old('nama_prodi') }}" />
            <x-forms.error name='nama_prodi'/>

            <label class="label font-bold mt-2" for="kode_jurusan">Kode Jurusan</label>
            <select class="select select-bordered w-full" name="kode_jurusan" required>
                <option disabled selected>Pilih Jurusan</option>
                @foreach ($jurusans as $jurusan)
                    <option value="{{ $jurusan->kode_jurusan }}">
                        {{ $jurusan->kode_jurusan }}
                    </option>
                @endforeach
            </select>

            <x-forms.error name='kode_jurusan'/>

            <button class="btn btn-primary mt-4">Buat Prodi</button>
        </fieldset>

    </form>
</div>
</x-layout>