<x-layout>
    <a class="join-item btn btn-primary" href="/admin/kelola-user">⮜ Previous page</a>
    <form class="flex h-screen"action="/admin/kelola-user/{{$user->username}}" method="POST">
    @csrf
    @method('PATCH')
    <p>{{$user}}</p>
    <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-xs h-64 border p-4 mx-auto">

        <label class="label font-bold" for="username">Username</label>
        <input type="text" class="input" name="username" placeholder="Username/NRP" value="{{$user->username}}"/>
        <x-forms.error name='username'/>
        <label class="label font-bold" for="password">Password</label>
        <input type="password" class="input" name="password" placeholder="Password" value="{{$user->password}}" disabled/>
        <label class="label font-bold" for="level">Level</label>
        <select class="select" name="level">
                <option disabled>Pilih Level</option>
                <option value="1" {{$user->level === 1 ? "selected": ""}}>1 (Admin)</option>
                <option value="2" {{$user->level === 2 ? "selected": ""}}>2</option>
                <option value="3" {{$user->level === 3 ? "selected": ""}}>3</option>
                <option value="4" {{$user->level === 4 ? "selected": ""}}>4</option>
        </select>
        <label class="label font-bold" for="sks">SKS</label>
        <input type="number" class="input" name="sks" placeholder="Contoh: 20" required value="{{$user->sks}}"/>
        <button class="btn btn-primary mt-4">Edit Akun</button>
  </fieldset>

  </form>
</x-layout>