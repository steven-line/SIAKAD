<x-layout>
      <a class="join-item btn btn-primary" href="{{ route('fakultas.index') }}">
          ⮜ Previous page
      </a>

    <form class="flex"
          action="{{ route('fakultas.store') }}"
          method="POST">
    @csrf

    <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-xs  border p-4 mx-auto">

        <label class="label font-bold" for="nama_fakultas">nama_fakultas</label>
        <input type="text" maxlength="50" value="{{ old('nama_fakultas') }}" class="input" name="nama_fakultas" placeholder="" />
        <x-forms.error name='nama_fakultas'/>

        <button class="btn btn-primary mt-4">Buat fakultas</button>

    </fieldset>

    </form>
</x-layout>