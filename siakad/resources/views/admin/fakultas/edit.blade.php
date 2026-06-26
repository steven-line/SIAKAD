<x-layout>

    <a class="join-item btn btn-primary" href="{{ route('fakultas.index') }}">
        ⮜ Previous page
    </a>

    <form class="flex"
          action="{{ route('fakultas.update', $fakultas->id) }}"
          method="POST">

        @csrf
        @method('PATCH')

        <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-xs  border p-4 mx-auto">

            <label class="label font-bold" for="nama_fakultas">nama_fakultas</label>
            <input type="text" maxlength="50" class="input" name="nama_fakultas"
                   value="{{ old('nama_fakultas', $fakultas->nama_fakultas) }}" />
            <x-forms.error name='nama_fakultas'/>

            <button class="btn btn-primary mt-4">Ubah fakultas</button>

        </fieldset>

    </form>

</x-layout>