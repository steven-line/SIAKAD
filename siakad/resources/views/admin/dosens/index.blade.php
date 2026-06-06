<x-layout title="index">
 <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100">
    <a class="btn btn-primary text-white mb-6" href="/admin/kelola-dosen/create">Create Dosen</a>
  <table class="table">
    <!-- head -->
    <thead class="bg-blue-500 text-white">
      <tr>
        <th>No</th>
        <th>nim_dosen</th>
        <th>nip</th>
        <th>nama</th>
        <th>user_id</th>
        <th colspan="3">Aksi</th>
      </tr>
    </thead>
    <tbody>
      <!-- row 1 -->
       @forelse($dosens as $dosen)
        <tr>
            <td>{{$loop->index}}</td>
            <td>{{$dosen->nim_dosen}}</td>
            <td>{{$dosen->nip}}</td>
            <td>{{$dosen->nama}}</td>
            <td>{{$dosen->user_id}}</td>
            <td><a class="btn btn-soft btn-info"href="">Detail</a></td>
            <td><a class="btn btn-soft btn-warning" href="/admin/kelola-dosen/{{$dosen->nim_dosen}}/edit">Edit</a>
         </td>
            <td>
              <button class="btn btn-soft btn-error" onclick="deleteBox_{{$dosen->nim_dosen}}.showModal()">Delete</button>
              <dialog id="deleteBox_{{$dosen->nim_dosen}}" class="modal modal-bottom sm:modal-middle">
                <div class="modal-box">
                  <h3 class="text-lg font-bold">Peringatan Penghapusan</h3>
                  <p class="py-4">Apa anda yakin ingin menghapus?</p>
                  <div class="modal-action">
                    <form method="dialog">
                      <!-- if there is a button in form, it will close the modal -->
                      <button class="btn btn-primary" form="delete-dosen-form-{{$dosen->nim_dosen}}">Ya</button>
                      <button class="btn btn-neutral">Tidak</button>
                    </form>
                  </div>
                </div>
              </dialog>
            </td>
           
        </tr>
               <form id="delete-dosen-form-{{$dosen->nim_dosen}}" action="/admin/kelola-dosen/{{ $dosen->nim_dosen }}" method='POST'>
            @csrf  
            @method('DELETE')
       </form>
  
        
      @empty
      <tr>
        <td colspan="5" class="text-center">Tidak ada data</td>
      </tr>
      @endforelse
    </tbody>
  </table>
  <!-- Open the modal using ID.showModal() method -->
 

</div>
</x-layout>