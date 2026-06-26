<x-layout title="index">
<div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100">

    <a class="btn btn-primary text-white mb-6"
       href="{{ route('jurusan.create') }}">
        Create Jurusan
    </a>

    <table class="table">
        <thead class="bg-blue-500 text-white">
        <tr>
            <th>No</th>
            <th>Kode Jurusan</th>
            <th>Nama Jurusan</th>
            <th>Program Pendidikan</th>
            <th>SK BAN</th>
            <th>Keterangan</th>
            <th>Fakultas</th>
            <th colspan="3">Aksi</th>
        </tr>
        </thead>

        <tbody>
        @forelse($jurusans as $jurusan)
            <tr>
                <th>{{ $loop->index + 1 }}</th>
                <td>{{ $jurusan->kode_jurusan }}</td>
                <td>{{ $jurusan->nama_jurusan ?? '-' }}</td>
                <td>{{ $jurusan->program_pendidikan }}</td>
                <td>{{ $jurusan->sk_ban }}</td>
                <td>{{ $jurusan->keterangan ?? '-' }}</td>
                <td>{{ $jurusan->fakultas->nama_fakultas ?? '-' }}</td>

                {{-- DETAIL --}}
                <td>
                    <a href="{{ route('jurusan.show', $jurusan->kode_jurusan) }}"
                       class="btn btn-soft btn-primary">
                        Detail
                    </a>
                </td>

                {{-- EDIT --}}
                <td>
                    <a class="btn btn-soft btn-warning"
                       href="{{ route('jurusan.edit', $jurusan->kode_jurusan) }}">
                        Edit
                    </a>
                </td>

                {{-- DELETE BUTTON --}}
                <td>
                    <button class="btn btn-soft btn-error"
                            onclick="deleteBox_{{ $jurusan->kode_jurusan }}.showModal()">
                        Delete
                    </button>

                    <dialog id="deleteBox_{{ $jurusan->kode_jurusan }}"
                            class="modal modal-bottom sm:modal-middle">
                        <div class="modal-box">
                            <h3 class="text-lg font-bold">Peringatan Penghapusan</h3>
                            <p class="py-4">Apa anda yakin ingin menghapus jurusan ini?</p>

                            <div class="modal-action">
                                <form method="dialog">
                                    <button class="btn btn-neutral">Tidak</button>
                                </form>

                                <form method="POST"
                                      action="{{ route('jurusan.destroy', $jurusan->kode_jurusan) }}">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-primary">
                                        Ya
                                    </button>
                                </form>
                            </div>
                        </div>
                    </dialog>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="9" class="text-center">Tidak ada data</td>
            </tr>
        @endforelse

        <tr>
            <td colspan="9">
                {{ $jurusans->links() }}
            </td>
        </tr>
        </tbody>
    </table>

</div>
</x-layout>