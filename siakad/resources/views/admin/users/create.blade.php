<x-layout>
      <a class="join-item btn btn-primary" href="/admin/kelola-user">⮜ Previous page</a>
    <form class="flex h-screen"action="/admin/kelola-user/create" method="POST">
    @csrf
    <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-xs h-64 sborder p-4 mx-auto">

        <label class="label font-bold" for="username">Username</label>
        <input type="text" class="input" name="username" placeholder="Username/NRP" />
        <x-forms.error name='username'/>
        <label class="label font-bold" for="password">Password</label>
        <input type="password" class="input" name="password" placeholder="Password" />
        <label class="label font-bold" for="level">Level</label>
        <select class="select" name="level">
            <option disabled selected>Pilih Level</option>
                <option value="1">1 (Admin)</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
        </select>
        <label class="label font-bold" for="sks">SKS</label>
        <input type="number" class="input" name="sks" placeholder="Contoh: 20" />
        <button class="btn btn-primary mt-4">Buat Akun</button>
  </fieldset>

  </form>
</x-layout>