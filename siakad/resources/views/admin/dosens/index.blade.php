<x-layout title="index">
 <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100">

    <a class="btn btn-primary text-white mb-6" href="{{ route('dosen.create') }}">
        Create Dosen
    </a>

  <table class="table">
    <thead class="bg-blue-500 text-white">
      <tr>
        <th>No</th>
        <th>nim_dosen</th>
        <th>nip</th>
        <th>nama</th>
        <th>user_id</th>
        <th>prodi</th>
        <th>jabatan_struktural</th>
        <th colspan="3">Aksi</th>
      </tr>
    </thead>

    <tbody>
      @forelse($dosens as $dosen)
        <tr>
            <td>{{ $loop->index }}</td>
            <td>{{ $dosen->nim_dosen }}</td>
            <td>{{ $dosen->nip }}</td>
            <td>{{ $dosen->nama }}</td>
            <td>{{ $dosen->user_id }}</td>
            <td>{{ $dosen->prodi }}</td>
            <td>{{ $dosen->jabatan_struktural }}</td>

            <td>
                <a class="btn btn-soft btn-info">
                    Detail
                </a>
            </td>

            <td>
                <a class="btn btn-soft btn-warning"
                   href="{{ route('dosen.edit', $dosen->nim_dosen) }}">
                    Edit
                </a>
            </td>

            <td>
              <button class="btn btn-soft btn-error"
                      onclick="deleteBox_{{ $dosen->nim_dosen }}.showModal()">
                Delete
              </button>

              <dialog id="deleteBox_{{ $dosen->nim_dosen }}" class="modal modal-bottom sm:modal-middle">
                <div class="modal-box">
                  <h3 class="text-lg font-bold">Peringatan Penghapusan</h3>
                  <p class="py-4">Apa anda yakin ingin menghapus?</p>

                  <div class="modal-action">
                    <form method="dialog">
                      <button class="btn btn-primary" form="delete-dosen-form-{{ $dosen->nim_dosen }}">
                        Ya
                      </button>
                      <button class="btn btn-neutral">Tidak</button>
                    </form>
                  </div>
                </div>
              </dialog>
            </td>
        </tr>

        <form id="delete-dosen-form-{{ $dosen->nim_dosen }}"
              action="{{ route('dosen.destroy', $dosen->nim_dosen) }}"
              method="POST">
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

</div>
</x-layout>