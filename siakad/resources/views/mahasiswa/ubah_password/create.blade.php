<x-layout>
    
    <a class="join-item btn btn-primary" href="/admin/kelola-user">⮜ Previous page</a>
        <form class="flex"action="/mahasiswa/ubah-password" method="POST">
        @csrf
        @method('PATCH')

        <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-xs  border p-6 mx-auto">
            <label class="label font-bold" for="password_lama">Password Lama</label>
            <input type="password" class="input" name="password_lama" placeholder="Password" >
            <x-forms.error name='password_lama'></x-forms.error>
            <label class="label font-bold" for="password_baru">Password Baru</label>
            <input type="password" class="input" name="password_baru" />
             <x-forms.error name='password_baru'></x-forms.error>
            <label class="label font-bold" for="password_baru_confirmation">Konfirmasi Password Baru</label>
            <input type="password" class="input" name="password_baru_confirmation" />
             <x-forms.error name='password_baru_confirmation'></x-forms.error>
             
            <button class="btn btn-primary mt-4">Ubah Password</button>
    </fieldset>

  </form>
</x-layout>