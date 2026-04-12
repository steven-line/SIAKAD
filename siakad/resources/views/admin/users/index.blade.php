<x-layout title="index">
 <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100">
    <a class="btn btn-primary text-white mb-6" href="/admin/kelola-user/create">Create User</a>
  <table class="table">
    <!-- head -->
    <thead class="bg-blue-500 text-white">
      <tr>
        <th>No</th>
        <th>Username</th>

        <th>Level</th>
        <th>Sks</th>
        <th>First Login</th>
        <th>Last Login</th>
        <th>Validasi</th>
        <th>Akses Nilai</th>
        <th>Pataum</th>
        <th>Aktif</th>
        <th>Detail</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <!-- row 1 -->
       @foreach($users as $user)
        <tr>
            <th>{{$loop->index}}</th>
            <th>{{$user->username}}</th>
  
            <th>{{$user->level}}</th>
            <th>{{$user->sks}}</th>
            <th>{{$user->firstlogin}}</th>
            <th>{{$user->lastlogin}}</th>
            <th>{{$user->validasi}}</th>
            <th>{{$user->aksesnilai}}</th>
            <th>{{$user->pataum}}</th>
            <th>{{$user->aktif}}</th>
            <th><a href=''>Detail</a></th>
            
            <th><form action="/admin/kelola-user/{{ $user->username }}" method='POST'>
            @csrf  
            @method('DELETE')

              <button class="btn  btn-error">Delete</button>
            </form></th>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
</x-layout>