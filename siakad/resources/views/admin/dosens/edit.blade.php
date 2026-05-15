<x-layout>
      <a class="join-item btn btn-primary" href="/admin/kelola-dosen">⮜ Previous page</a>
    <form class="flex h-screen"action="/admin/kelola-dosen/{{$dosen->nim_dosen}}" method="POST">
    @csrf
    @method('PATCH')
    <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-xs h-80 border p-4 mx-auto">

        <label class="label font-bolad" for="nim_dosen">NIM DOSEN</label>
        <input type="text" class="input" name="nim_dosen" placeholder="" value="{{$dosen->nim_dosen}}"/>
        <x-forms.error name='nim_dosen'/>

        <label class="label font-bold" for="nip">NIP</label>
        <input type="text" class="input" name="nip" placeholder="" value="{{$dosen->nip}}"/>
        <x-forms.error name='nip'/>
        
        <label class="label font-bold" for="nama">Nama</label>
        <input type="text" class="input" name="nama" placeholder="" value="{{$dosen->nama}}"/>
        <x-forms.error name='nama'/>
        

        <button class="btn btn-primary mt-4">Ubah Dosen</button>
  </fieldset>

  </form>
</x-layout>