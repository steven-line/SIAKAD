<x-layout title="index">
<div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100">

    <a class="btn btn-primary text-white mb-6"
       href="{{ route('kurikulum.create') }}">
        Create Kurikulum
    </a>

    <table class="table">
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
        @forelse($kurikulums as $kurikulum)
            <tr>
                <th>{{ $loop->index }}</th>

                <th>{{ $kurikulum->kode_kurikulum }}</th>
                <th>{{ $kurikulum->nama_kurikulum }}</th>
                <th>{{ $kurikulum->aktif ? "aktif" : "tidak aktif" }}</th>

                {{-- DETAIL --}}
                <th>
                    <a href="{{ route('kurikulum.show', $kurikulum->kode_kurikulum) }}"
                       class="btn btn-soft btn-primary">
                        Detail
                    </a>
                </th>

                {{-- EDIT --}}
                <th>
                    <a class="btn btn-soft btn-warning"
                       href="{{ route('kurikulum.edit', $kurikulum->kode_kurikulum) }}">
                        Edit
                    </a>
                </th>

                {{-- DELETE BUTTON --}}
                <th>
                    <button class="btn btn-soft btn-error"
                            onclick="deleteBox_{{ $kurikulum->kode_kurikulum }}.showModal()">
                        Delete
                    </button>

                    <dialog id="deleteBox_{{ $kurikulum->kode_kurikulum }}"
                            class="modal modal-bottom sm:modal-middle">
                        <div class="modal-box">
                            <h3 class="text-lg font-bold">Peringatan Penghapusan</h3>
                            <p class="py-4">Apa anda yakin ingin menghapus?</p>

                            <div class="modal-action">
                                <form method="dialog">
                                    <button class="btn btn-neutral">Tidak</button>
                                </form>

                                <form method="POST"
                                      action="{{ route('kurikulum.destroy', $kurikulum->kode_kurikulum) }}">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-primary">
                                        Ya
                                    </button>
                                </form>
                            </div>
                        </div>
                    </dialog>
                </th>
            </tr>

            <form id="delete-kurikulum-form-{{ $kurikulum->kode_kurikulum }}"
                  action="{{ route('kurikulum.destroy', $kurikulum->kode_kurikulum) }}"
                  method="POST">
                @csrf
                @method('DELETE')
            </form>
         @empty
            <tr>
                <td colspan="5" class="text-center">Tidak ada data</td>
            </tr>

        @endforelse
        <td>{{$kurikulums->links()}}</td>
        </tbody>
    </table>

</div>
</x-layout>