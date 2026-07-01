<x-layout title="index">
  {{-- NOTIFIKASI SUCCESS --}}
    @if (session('success'))
        <div class="alert alert-success mb-4">
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- NOTIFIKASI ERROR --}}
    @if (session('error'))
        <div class="alert alert-error mb-4">
            <span>{{ session('error') }}</span>
        </div>
    @endif

    {{-- VALIDATION ERROR --}}
    @if ($errors->any())
        <div class="alert alert-error mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
  <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100">
      <a class="btn btn-primary text-white mb-6" href="{{ route('biodata.create') }}">
        Create Biodata
      </a>
      <form action="{{route('biodata.upload')}}" class="mb-10" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file"  accept=".csv, .xlsx, .xls" class="file-input">
          <input type="submit" value="Upload File" class="btn btn-primary">
      </form>
       <a href=" {{ asset('document/template_import_biodata.xlsx') }}" download class="btn btn-success mb-5">Download Template</a>
    <table class="table">
      <thead class="bg-blue-500 text-white">
        <tr>
          <th>No</th>
          <th>nrp</th>
          <th>nama</th>
          <th>nik</th>
          <th>tempat_lahir</th>
          <th>tanggal_lahir</th>
          <th>jenis_kelamin</th>
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
              <td>{{ $biodata->jenis_kelamin }}</td>
              <th>{{ $biodata->tinggi }}</th>
              <th>{{ $biodata->berat }}</th>
              <th>{{ $biodata->alamat }}</th>

              <td>
                <a class="btn btn-soft btn-info" href="{{ route('biodata.show', $biodata->id) }}">
                  Detail
                </a>
              </td>

              <td>
                <a class="btn btn-soft btn-warning"
                   href="{{ route('biodata.edit', $biodata->id) }}">
                  Edit
                </a>
              </td>

              <td>
                <button class="btn btn-soft btn-error"
                        onclick="deleteBox_{{ $biodata->id }}.showModal()">
                  Delete
                </button>

                <dialog id="deleteBox_{{ $biodata->id }}" class="modal modal-bottom sm:modal-middle">
                  <div class="modal-box">
                    <h3 class="text-lg font-bold">Peringatan Penghapusan</h3>
                    <p class="py-4">Apa anda yakin ingin menghapus?</p>

                    <div class="modal-action">
                      <form method="dialog">
                        <button class="btn btn-primary"
                                form="delete-biodata-form-{{ $biodata->id }}">
                          Ya
                        </button>
                        <button class="btn btn-neutral">Tidak</button>
                      </form>
                    </div>
                  </div>
                </dialog>
              </td>
          </tr>

          <form id="delete-biodata-form-{{ $biodata->id }}"
                action="{{ route('biodata.destroy', $biodata->id) }}"
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