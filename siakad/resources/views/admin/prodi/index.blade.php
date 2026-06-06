<x-layout title="index">
 <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100">
    <a class="btn btn-primary text-white mb-6" href="/admin/kelola-prodi/create">Create Prodi</a>
  <table class="table">
    <!-- head -->
    <thead class="bg-blue-500 text-white">
      <tr>
        <th>No</th>
        <th>Kode Prodi</th>
        <th>Nama Prodi</th>
        <th colspan="3">Aksi</th>
      </tr>
    </thead>
    <tbody>
      <!-- row 1 -->
       @foreach($prodis as $prodi)
        <tr>
            <th>{{$loop->index}}</th>
           
            <th>{{$prodi->kode_prodi}}</th>
            <th>{{$prodi->nama_prodi}}</th>
            <th><a href='' class="btn btn-soft btn-primary">Detail</a></th>
            <th><a class="btn btn-soft btn-warning" href="/admin/kelola-prodi/{{$prodi->kode_prodi}}/edit">Edit</a></th>
            <th>
              <button class="btn btn-soft btn-error" onclick="deleteBox_{{$prodi->kode_prodi}}.showModal()">Delete</button>
              <dialog id="deleteBox_{{$prodi->kode_prodi}}" class="modal modal-bottom sm:modal-middle">
                <div class="modal-box">
                  <h3 class="text-lg font-bold">Peringatan Penghapusan</h3>
                  <p class="py-4">Apa anda yakin ingin menghapus?</p>
                  <div class="modal-action">
                    <form method="dialog">
                      <!-- if there is a button in form, it will close the modal -->
                      <button class="btn btn-primary" form="delete-prodi-form-{{$prodi->kode_prodi}}">Ya</button>
                      <button class="btn btn-neutral">Tidak</button>
                    </form>
                  </div>
                </div>
              </dialog>
            </th>
        </tr>

        <form id="delete-prodi-form-{{$prodi->kode_prodi}}" action="/admin/kelola-prodi/{{ $prodi->kode_prodi }}" method='POST'>
            @csrf  
            @method('DELETE')
       </form>
      @endforeach
    </tbody>
  </table>
  <!-- Open the modal using ID.showModal() method -->
 

</div>
</x-layout>