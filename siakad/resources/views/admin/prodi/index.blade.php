<x-layout title="index">
 <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100">

    <a class="btn btn-primary text-white mb-6" href="{{ route('prodi.create') }}">
        Create Prodi
    </a>

  <table class="table">
    <thead class="bg-blue-500 text-white">
      <tr>
        <th>No</th>
        <th>Kode Prodi</th>
        <th>Nama Prodi</th>
        <th>Kode Jurusan</th>  
        <th>Kode Prodi Dikti</th>    
        <th colspan="3">Aksi</th>
      </tr>
    </thead>

    <tbody>
       @foreach($prodis as $prodi)
        <tr>
            <th>{{ $loop->index }}</th>
           
            <th>{{ $prodi->kode_prodi }}</th>
            <th>{{ $prodi->nama_prodi }}</th>
            <th>{{ $prodi->kode_jurusan }}</th>
            <th>{{ $prodi->kode_prodi_dikti }}</th>

            <th>
                <a href="{{ route('prodi.show', $prodi->kode_prodi) }}" class="btn btn-soft btn-primary">Detail</a>
            </th>

            <th>
                <a class="btn btn-soft btn-warning"
                   href="{{ route('prodi.edit', $prodi->kode_prodi) }}">
                   Edit
                </a>
            </th>

            <th>
              <button class="btn btn-soft btn-error"
                      onclick="deleteBox_{{ $prodi->kode_prodi }}.showModal()">
                Delete
              </button>

              <dialog id="deleteBox_{{ $prodi->kode_prodi }}" class="modal modal-bottom sm:modal-middle">
                <div class="modal-box">
                  <h3 class="text-lg font-bold">Peringatan Penghapusan</h3>
                  <p class="py-4">Apa anda yakin ingin menghapus?</p>

                  <div class="modal-action">
                    <form method="dialog">
                      <button class="btn btn-primary"
                              form="delete-prodi-form-{{ $prodi->kode_prodi }}">
                        Ya
                      </button>
                      <button class="btn btn-neutral">Tidak</button>
                    </form>
                  </div>
                </div>
              </dialog>
            </th>

        </tr>

        <form id="delete-prodi-form-{{ $prodi->kode_prodi }}"
              action="{{ route('prodi.destroy', $prodi->kode_prodi) }}"
              method="POST">
            @csrf  
            @method('DELETE')
        </form>

      @endforeach
    </tbody>
    <td>{{$prodis->links()}}</td>
  </table>

</div>
</x-layout>