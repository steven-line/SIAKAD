<x-layout title="index">
<div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100">

    <a class="btn btn-primary text-white mb-6"
       href="{{ route('semester.create') }}">
        Create Semester
    </a>

    <table class="table">
        <thead class="bg-blue-500 text-white">
        <tr>
            <th>No</th>
            <th>Id</th>
            <th>Semester</th>
            <th>Periode</th>
            <th>Jenis</th>
            <th>Aktif </th>
            <th>Created At</th>
            <th>Updated At</th>
            <th colspan="3">Aksi</th>
        </tr>
        </thead>

        <tbody>
        @forelse($semesters as $semester)
            <tr>
                <th>{{ $loop->index }}</th>
                <th>{{$semester->id}}</th>
                <th>{{$semester->nama}}</th>
                <th>{{ $semester->periode->tahun_ajaran}}</th>
                <th>{{ $semester->jenis }}</th>
                <th>{{ $semester->aktif  ? 'Aktif': 'Tidak Aktif'}}</th>
                <th>{{ $semester->created_at }}</th>
                <th>{{ $semester->updated_at }}</th>
                {{-- DETAIL --}}
                <th>
                    <a href="{{ route('semester.show', $semester->id) }}"
                       class="btn btn-soft btn-primary">
                        Detail
                    </a>
                </th>

                {{-- EDIT --}}
                <th>
                    <a class="btn btn-soft btn-warning"
                       href="{{ route('semester.edit', $semester->id) }}">
                        Edit
                    </a>
                </th>

                {{-- DELETE BUTTON --}}
                <th>
                    <button class="btn btn-soft btn-error"
                            onclick="deleteBox_{{ $semester->id }}.showModal()">
                        Delete
                    </button>

                    <dialog id="deleteBox_{{ $semester->id }}"
                            class="modal modal-bottom sm:modal-middle">
                        <div class="modal-box">
                            <h3 class="text-lg font-bold">Peringatan Penghapusan</h3>
                            <p class="py-4">Apa anda yakin ingin menghapus?</p>

                            <div class="modal-action">
                                <form method="dialog">
                                    <button class="btn btn-neutral">Tidak</button>
                                </form>

                                <form method="POST"
                                    action="{{ route('semester.destroy', $semester->id) }}">
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

            <form id="delete-semester-form-{{ $semester->id }}"
                  action="{{ route('semester.destroy', $semester->id) }}"
                  method="POST">
                @csrf
                @method('DELETE')
            </form>
         @empty
            <tr>
                <td colspan="5" class="text-center">Tidak ada data</td>
            </tr>

        @endforelse
        <td>{{$semesters->links()}}</td>
        </tbody>
    </table>

</div>
</x-layout>