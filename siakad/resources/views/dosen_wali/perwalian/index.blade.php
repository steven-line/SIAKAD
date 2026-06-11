<x-layout title="index">
 <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100">
  <table class="table">
    <!-- head -->
    <thead class="bg-blue-500 text-white">
      <tr>
        <th>No</th>
        <th>NRP</th>
        <th>Nama</th>
        <th>Dosen Wali</th>
        <th>Status</th>
        <th colspan="3">Aksi</th>
      </tr>
    </thead>
    <tbody>
      <!-- row 1 -->
       @forelse($mahasiswas as $mahasiswa)
        <tr>
            <td>{{$loop->index}}</td>
            <td>{{$mahasiswa->nrp}}</td>
            <td>{{$mahasiswa->biodata->nama}}</td>
            <td>{{$mahasiswa->dosen_wali}}</td>
            <td>Status (non blokiran)</td>
            <td><a class="btn btn-soft btn-info"href="/dosen-wali/perwalian/{{$mahasiswa->nrp}}">Detail</a></td>
            <td><a class="btn btn-soft btn-warning" href="/admin/kelola-mahasiswa/{{$mahasiswa->nrp}}/edit">Edit</a>
         </td>
            <td>
              <button class="btn btn-soft btn-error" onclick="deleteBox_{{$mahasiswa->nrp}}.showModal()">Delete</button>
              <dialog id="deleteBox_{{$mahasiswa->nrp}}" class="modal modal-bottom sm:modal-middle">
                <div class="modal-box">
                  <h3 class="text-lg font-bold">Peringatan Penghapusan</h3>
                  <p class="py-4">Apa anda yakin ingin menghapus?</p>
                  <div class="modal-action">
                    <form method="dialog">
                      <!-- if there is a button in form, it will close the modal -->
                      <button class="btn btn-primary" form="delete-mahasiswa-form-{{$mahasiswa->nrp}}">Ya</button>
                      <button class="btn btn-neutral">Tidak</button>
                    </form>
                  </div>
                </div>
              </dialog>
            </td>
           
        </tr>
               <form id="delete-mahasiswa-form-{{$mahasiswa->nrp}}" action="/admin/kelola-mahasiswa/{{ $mahasiswa->nrp }}" method='POST'>
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