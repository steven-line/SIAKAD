<x-layout title="index">
 <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100">
    <a class="btn btn-primary text-white mb-6" href="/admin/kelola-matakuliah/create">Create Mata Kuliah</a>
  <table class="table">
    <!-- head -->
    <thead class="bg-blue-500 text-white">
      <tr>
        <th>No</th>
        <th>kodemk</th>
        <th>nama</th>
        <th>nm_jenj_didik</th>
        <th>kode_prodi_dikti</th>
        <th>kode_kurikulum</th>
        <th>aktif</th>

                
        <th colspan="3">Aksi</th>
      </tr>
    </thead>
    <tbody>
        @forelse ($mks as $mk)
             <tr>
            <td>{{$loop->index}}</td>
            <td class="text-center">{{$mk->kodemk}}</td>
            <td class="text-center">{{$mk->nama}}</td>
            <td class="text-center">{{$mk->nm_jenj_didik}}</td>
            <td class="text-center">{{$mk->kode_prodi_dikti}}</td>
            <td class="text-center">{{$mk->kode_kurikulum}}</td>
            <th>{{$mk->aktif ?  "aktif": "tidak aktif"}}</th>
            <th><a href='/admin/kelola-matakuliah/{{$mk->kodemk}}' class="btn btn-soft btn-primary">Detail</a></th>
            <th><a class="btn btn-soft btn-warning" href="/admin/kelola-matakuliah/{{$mk->kodemk}}/edit">Edit</a></th>
            <td>
              <button class="btn btn-soft btn-error" onclick="deleteBox_{{$mk->kodemk}}.showModal()">Delete</button>
              <dialog id="deleteBox_{{$mk->kodemk}}" class="modal modal-bottom sm:modal-middle">
                <div class="modal-box">
                  <h3 class="text-lg font-bold">Peringatan Penghapusan</h3>
                  <p class="py-4">Apa anda yakin ingin menghapus?</p>
                  <div class="modal-action">
                    <form method="dialog">
                      <!-- if there is a button in form, it will close the modal -->
                      <button class="btn btn-primary" form="delete-mk-form-{{$mk->kodemk}}">Ya</button>
                      <button class="btn btn-neutral">Tidak</button>
                    </form>
                  </div>
                </div>
              </dialog>
            </td>
        </tr>     
        <form id="delete-mk-form-{{$mk->kodemk}}" action="/admin/kelola-matakuliah/{{$mk->kodemk}}" method='POST'>
            @csrf  
            @method('DELETE')
       </form>
        @empty
          <tr>
            <td colspan="17" class="text-center">Tidak ada data</td>
          </tr>
        @endforelse
       
    </tbody>
      <!-- row 1 -->
     

</div>
</x-layout>