<x-layout title="index">
 <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100">
    <a class="btn btn-primary text-white mb-6" href="/admin/kelola-kurikulum/create">Create Kurikulum</a>
  <table class="table">
    <!-- head -->
    <thead class="bg-blue-500 text-white">
      <tr>
        <th>No</th>
        <th>Kode Kurikulum</th>
        <th>Nama Kurikulum</th>
        <th>Aktif</th>
    
        <th colspan="3">Aksi</th>
      </tr>
    </thead>
    <tbody>
      <!-- row 1 -->
       @foreach($kurikulums as $kurikulum)
        <tr>
            <th>{{$loop->index}}</th>
           
            <th>{{$kurikulum->kode_kurikulum}}</th>
            <th>{{$kurikulum->nama_kurikulum}}</th>
            <th>{{$kurikulum->aktif ? "aktif": "tidak aktif"}}</th>
            <th><a href="/admin/kelola-kurikulum/{{$kurikulum->kode_kurikulum}}" class="btn btn-soft btn-primary">Detail</a></th>
            <th><a class="btn btn-soft btn-warning" href="/admin/kelola-kurikulum/{{$kurikulum->kode_kurikulum}}/edit">Edit</a></th>
            <th>
              <button class="btn btn-soft btn-error" onclick="deleteBox_{{$kurikulum->kode_kurikulum}}.showModal()">Delete</button>
              <dialog id="deleteBox_{{$kurikulum->kode_kurikulum}}" class="modal modal-bottom sm:modal-middle">
                <div class="modal-box">
                  <h3 class="text-lg font-bold">Peringatan Penghapusan</h3>
                  <p class="py-4">Apa anda yakin ingin menghapus?</p>
                  <div class="modal-action">
                    <form method="dialog">
                      <!-- if there is a button in form, it will close the modal -->
                      <button class="btn btn-primary" form="delete-kurikulum-form-{{$kurikulum->kode_kurikulum}}">Ya</button>
                      <button class="btn btn-neutral">Tidak</button>
                    </form>
                  </div>
                </div>
              </dialog>
            </th>
        </tr>

        <form id="delete-kurikulum-form-{{$kurikulum->kode_kurikulum}}" action="/admin/kelola-kurikulum/{{ $kurikulum->kode_kurikulum }}" method='POST'>
            @csrf  
            @method('DELETE')
       </form>
      @endforeach
    </tbody>
  </table>
  <!-- Open the modal using ID.showModal() method -->
 

</div>
</x-layout>