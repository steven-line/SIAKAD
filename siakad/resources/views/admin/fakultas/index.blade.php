<x-layout title="index">
 <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100">
    <a class="btn btn-primary text-white mb-6" href="/admin/kelola-fakultas/create">Create fakultas</a>
  <table class="table">
    <!-- head -->
    <thead class="bg-blue-500 text-white">
      <tr>
        <th>No</th>
        <th>Kode Fakultas</th>
        <th>Nama Fakultas</th>
        <th colspan="3">Aksi</th>
      </tr>
    </thead>
    <tbody>
      <!-- row 1 -->
       @foreach($fakultass as $fakultas)
        <tr>
            <th>{{$loop->index}}</th>
           
            <th>{{$fakultas->kode_fakultas}}</th>
            <th>{{$fakultas->nama_fakultas}}</th>
            <th><a href='' class="btn btn-soft btn-primary">Detail</a></th>
            <th><a class="btn btn-soft btn-warning" href="/admin/kelola-fakultas/{{$fakultas->kode_fakultas}}/edit">Edit</a></th>
            <th>
              <button class="btn btn-soft btn-error" onclick="deleteBox_{{$fakultas->kode_fakultas}}.showModal()">Delete</button>
              <dialog id="deleteBox_{{$fakultas->kode_fakultas}}" class="modal modal-bottom sm:modal-middle">
                <div class="modal-box">
                  <h3 class="text-lg font-bold">Peringatan Penghapusan</h3>
                  <p class="py-4">Apa anda yakin ingin menghapus?</p>
                  <div class="modal-action">
                    <form method="dialog">
                      <!-- if there is a button in form, it will close the modal -->
                      <button class="btn btn-primary" form="delete-fakultas-form-{{$fakultas->kode_fakultas}}">Ya</button>
                      <button class="btn btn-neutral">Tidak</button>
                    </form>
                  </div>
                </div>
              </dialog>
            </th>
        </tr>

        <form id="delete-fakultas-form-{{$fakultas->kode_fakultas}}" action="/admin/kelola-fakultas/{{ $fakultas->kode_fakultas }}" method='POST'>
            @csrf  
            @method('DELETE')
       </form>
      @endforeach
    </tbody>
  </table>
  <!-- Open the modal using ID.showModal() method -->
 

</div>
</x-layout>