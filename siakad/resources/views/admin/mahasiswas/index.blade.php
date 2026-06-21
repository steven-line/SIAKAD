<x-layout title="index">
 <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100">
    <a class="btn btn-primary text-white mb-6" href="{{route('mahasiswa_admin.create')}}">Create Mahasiswa</a>
    <table class="table">
    <thead class="bg-blue-500 text-white">
      <tr>
        <th>No</th>
        <th>Nrp</th>
        <th>Dosen Wali</th>
        <th>Status Blokir</th>
        <th>Prodi</th>       
        <th colspan="3">Aksi</th>
      </tr>
    </thead>
    <tbody>
      <!-- row 1 -->
       @foreach($mahasiswas as $mahasiswa)
        <tr>
            <th>{{$loop->index}}</th>
           
            <th>{{$mahasiswa->nrp}}</th>
            <th>{{$mahasiswa->dosen_wali}}</th>
            <th>{{$mahasiswa->status_blokir}}</th>
            <th>{{$mahasiswa->prodi}}</th>
            <th><a href='{{route('mahasiswa_admin.show', $mahasiswa->nrp)}}' class="btn btn-soft btn-primary">Detail</a></th>
            <th><a class="btn btn-soft btn-warning" href="{{route('mahasiswa_admin.edit',$mahasiswa->nrp)}}">Edit</a></th>
            <th>
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
            </th>
        </tr>
        
        <form id="delete-mahasiswa-form-{{$mahasiswa->nrp}}" action="{{route('mahasiswa_admin.destroy', $mahasiswa->nrp) }}" method='POST'>
            @csrf  
            @method('DELETE')
       </form>
      @endforeach
      <td>
      {{ $mahasiswas->links() }}</td>
    </tbody>
  </table>
  <!-- Open the modal using ID.showModal() method -->
 

</div>
</x-layout>