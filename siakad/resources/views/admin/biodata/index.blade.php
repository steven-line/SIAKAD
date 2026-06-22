<x-layout title="index">
  <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100">
      <a class="btn btn-primary text-white mb-6" href="{{ route('biodata.create') }}">
        Create Biodata
      </a>

    <table class="table">
      <thead class="bg-blue-500 text-white">
        <tr>
          <th>No</th>
          <th>nrp</th>
          <th>nama</th>
          <th>nik</th>
          <th>tempat_lahir</th>
          <th>tanggal_lahir</th>
          <th>sex</th>
          <th>tinggi</th>
          <th>berat</th>
          <th>alamat</th>
          <th colspan="3">Aksi</th>
        </tr>
      </thead>

      <tbody>
        @forelse($biodatas as $biodata)
          <tr>
              <td>{{ $loop->index }}</td>
              <td>{{ $biodata->nrp }}</td>
              <td>{{ $biodata->nama }}</td>
              <td>{{ $biodata->nik }}</td>
              <td>{{ $biodata->tempat_lahir }}</td>
              <td>{{ $biodata->tanggal_lahir }}</td>
              <td>{{ $biodata->sex }}</td>
              <th>{{ $biodata->tinggi }}</th>
              <th>{{ $biodata->berat }}</th>
              <th>{{ $biodata->alamat }}</th>

              <td>
                <a class="btn btn-soft btn-info" href="{{ route('biodata.show', $biodata->nrp) }}">
                  Detail
                </a>
              </td>

              <td>
                <a class="btn btn-soft btn-warning"
                   href="{{ route('biodata.edit', $biodata->nrp) }}">
                  Edit
                </a>
              </td>

              <td>
                <button class="btn btn-soft btn-error"
                        onclick="deleteBox_{{ $biodata->nrp }}.showModal()">
                  Delete
                </button>

                <dialog id="deleteBox_{{ $biodata->nrp }}" class="modal modal-bottom sm:modal-middle">
                  <div class="modal-box">
                    <h3 class="text-lg font-bold">Peringatan Penghapusan</h3>
                    <p class="py-4">Apa anda yakin ingin menghapus?</p>

                    <div class="modal-action">
                      <form method="dialog">
                        <button class="btn btn-primary"
                                form="delete-biodata-form-{{ $biodata->nrp }}">
                          Ya
                        </button>
                        <button class="btn btn-neutral">Tidak</button>
                      </form>
                    </div>
                  </div>
                </dialog>
              </td>
          </tr>

          <form id="delete-biodata-form-{{ $biodata->nrp }}"
                action="{{ route('biodata.destroy', $biodata->nrp) }}"
                method="POST">
              @csrf
              @method('DELETE')
          </form>

        @empty
          <tr>
            <td colspan="5" class="text-center">Tidak ada data</td>
          </tr>
        @endforelse
        <td>{{$biodatas->links()}}</td>
      </tbody>
    </table>

  </div>
</x-layout>