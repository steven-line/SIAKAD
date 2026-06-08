<x-layout>
      <a class="join-item btn btn-primary" href="/admin/kelola-kurikulum">⮜ Previous page</a>
    <form class="flex h-screen"action="/admin/kelola-kurikulum" method="POST">
    @csrf
    <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-xs h-80 border p-4 mx-auto">

        <label class="label font-bold" for="kurikulum">kode_kurikulum</label>
        <input type="text" class="input" name="kode_kurikulum" placeholder="" />
        <x-forms.error name='kode_kurikulum'/>

        <label class="label font-bold" for="nama_kurikulum">nama_kurikulum</label>
        <input type="text" class="input" name="nama_kurikulum" placeholder="" />
        <x-forms.error name='nama_kurikulum'/>

        <label class="label font-bold" for="aktif">aktif</label>
        <input type="checkbox" class="checkbox" name="aktif" placeholder="" />
        <x-forms.error name='aktif'/>

        <button class="btn btn-primary mt-4">Buat Kurikulum</button>
  </fieldset>

  </form>
</x-layout>