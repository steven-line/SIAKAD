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
        <th colspan="3">Aksi</th>
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
            <th><a href='' class="btn btn-soft btn-primary">Detail</a></th>
            <th><a class="btn btn-soft btn-warning" href="/admin/kelola-user/{{$user->username}}/edit">Edit</a></th>
            <th>
              <button class="btn btn-soft btn-error" onclick="deleteBox_{{$user->username}}.showModal()">Delete</button>
              <dialog id="deleteBox_{{$user->username}}" class="modal modal-bottom sm:modal-middle">
                <div class="modal-box">
                  <h3 class="text-lg font-bold">Peringatan Penghapusan</h3>
                  <p class="py-4">Apa anda yakin ingin menghapus?</p>
                  <div class="modal-action">
                    <form method="dialog">
                      <!-- if there is a button in form, it will close the modal -->
                      <button class="btn btn-primary" form="delete-user-form-{{$user->username}}">Ya</button>
                      <button class="btn btn-neutral">Tidak</button>
                    </form>
                  </div>
                </div>
              </dialog>
            </th>
        </tr>

        <form id="delete-user-form-{{$user->username}}" action="/admin/kelola-user/{{ $user->username }}" method='POST'>
            @csrf  
            @method('DELETE')
       </form>
      @endforeach
    </tbody>
  </table>
  <!-- Open the modal using ID.showModal() method -->
 

</div>
</x-layout>