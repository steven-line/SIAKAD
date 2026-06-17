<x-layout>
    <a class="join-item btn btn-primary" href="{{ route('prodi.index') }}">
        ⮜ Previous page
    </a>

    <form class="flex h-screen" action="{{ route('prodi.store') }}" method="POST">
        @csrf

        <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-xs h-80 border p-4 mx-auto">

            <label class="label font-bold" for="kode_prodi">kode_prodi</label>
            <input type="text" class="input" name="kode_prodi" placeholder="" />
            <x-forms.error name='kode_prodi'/>

            <label class="label font-bold" for="nama_prodi">nama_prodi</label>
            <input type="text" class="input" name="nama_prodi" placeholder="" />
            <x-forms.error name='nama_prodi'/>

            <label class="label font-bold mt-2" for="kode_fakultas">Kode Fakultas</label>
            <select class="select select-bordered w-full" name="kode_fakultas" required>
                <option disabled selected>Pilih Fakultas</option>
                @foreach ($fakultass as $fakultas)
                    <option value="{{ $fakultas->kode_fakultas }}">
                        {{ $fakultas->kode_fakultas }}
                    </option>
                @endforeach
            </select>

            <x-forms.error name='kode_fakultas'/>

            <button class="btn btn-primary mt-4">Buat Prodi</button>
        </fieldset>

    </form>
</x-layout>