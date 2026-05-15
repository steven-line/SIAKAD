<x-layout>
      <a class="join-item btn btn-primary" href="/admin/kelola-dosen">⮜ Previous page</a>
    <form class="flex h-screen"action="/admin/kelola-dosen" method="POST">
    @csrf
    <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-xs h-80 border p-4 mx-auto">

        <label class="label font-bolad" for="nim_dosen">NIM DOSEN</label>
        <input type="text" class="input" name="nim_dosen" placeholder="" />
        <x-forms.error name='nim_dosen'/>

        <label class="label font-bold" for="nip">NIP</label>
        <input type="text" class="input" name="nip" placeholder="" />
        <x-forms.error name='nip'/>
        
        <label class="label font-bold" for="nama">Nama</label>
        <input type="text" class="input" name="nama" placeholder="" />
        <x-forms.error name='nama'/>
        

        <button class="btn btn-primary mt-4">Buat Dosen</button>
  </fieldset>

  </form>
</x-layout>