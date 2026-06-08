<x-layout>
    <a class="join-item btn btn-primary" href="/admin/kelola-kurikulum">⮜ Previous page</a>
    <form class="flex h-screen"action="/admin/kelola-kurikulum/{{$kurikulum->kode_kurikulum}}" method="POST">
    @csrf
    @method('PATCH')
    <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-xs h-80 border p-4 mx-auto">

        <label class="label font-bold" for="kode_kurikulum">kode_kurikulum</label>
        <input type="text" class="input" name="kode_kurikulum" placeholder="" value="{{$kurikulum->kode_kurikulum}}"/>
        <x-forms.error name='kode_kurikulum'/>

        <label class="label font-bold" for="nama_kurikulum" >nama_kurikulum</label>
        <input type="text" class="input" name="nama_kurikulum" placeholder="" value="{{$kurikulum->nama_kurikulum}}" />
        <x-forms.error name='nama_kurikulum'/>

        <label class="label font-bold" for="aktif" >aktif</label>
        <input type="checkbox" class="checakbox" name="aktif" placeholder="" @checked($kurikulum->aktif) />
        <x-forms.error name='aktif'/>

        <button class="btn btn-primary mt-4">Ubah Kurikulum</button>
  </fieldset>

  </form>
</x-layout>