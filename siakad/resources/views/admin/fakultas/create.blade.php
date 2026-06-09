<x-layout>
      <a class="join-item btn btn-primary" href="/admin/kelola-fakultas">⮜ Previous page</a>
    <form class="flex h-screen"action="/admin/kelola-fakultas" method="POST">
    @csrf
    <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-xs h-80 border p-4 mx-auto">

        <label class="label font-bold" for="kode_fakultas">kode_fakultas</label>
        <input type="text" class="input" name="kode_fakultas" placeholder="" />
        <x-forms.error name='kode_fakultas'/>

        <label class="label font-bold" for="nama_fakultas">nama_fakultas</label>
        <input type="text" class="input" name="nama_fakultas" placeholder="" />
        <x-forms.error name='nama_fakultas'/>

        <button class="btn btn-primary mt-4">Buat fakultas</button>
  </fieldset>

  </form>
</x-layout>