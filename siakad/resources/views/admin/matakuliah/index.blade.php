<x-layout title="index">

<div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100">

    <a class="btn btn-primary text-white mb-6"
       href="{{ route('mk.create') }}">
        Create Mata Kuliah
    </a>

    <table class="table">

        <thead class="bg-blue-500 text-white">
            <tr>
                <th>No</th>
                <th>kodemk</th>
                <th>nama</th>
                <th>nm_jenj_didik</th>
                <th>kode_kurikulum</th>
                <th>aktif</th>
                <th colspan="3">Aksi</th>
            </tr>
        </thead>

        <tbody>

        @forelse ($mks as $mk)
            <tr>

                <td>{{ $loop->iteration }}</td>

                <td class="text-center">{{ $mk->kodemk }}</td>
                <td class="text-center">{{ $mk->nama }}</td>
                <td class="text-center">{{ $mk->nm_jenj_didik }}</td>
                <td class="text-center">{{ $mk->kode_kurikulum }}</td>

                <td>
                    {{ $mk->aktif ? 'aktif' : 'tidak aktif' }}
                </td>

                {{-- DETAIL --}}
                <td>
                    <a href="{{ route('mk.show', $mk->kodemk) }}"
                       class="btn btn-soft btn-primary">
                        Detail
                    </a>
                </td>

                {{-- EDIT --}}
                <td>
                    <a href="{{ route('mk.edit', $mk->kodemk) }}"
                       class="btn btn-soft btn-warning">
                        Edit
                    </a>
                </td>

                {{-- DELETE --}}
                <td>
                    <button class="btn btn-soft btn-error"
                            onclick="deleteBox_{{ $mk->kodemk }}.showModal()">
                        Delete
                    </button>

                    <dialog id="deleteBox_{{ $mk->kodemk }}"
                            class="modal modal-bottom sm:modal-middle">

                        <div class="modal-box">
                            <h3 class="text-lg font-bold">
                                Peringatan Penghapusan
                            </h3>

                            <p class="py-4">
                                Apa anda yakin ingin menghapus?
                            </p>

                            <div class="modal-action">

                                <form method="dialog">
                                    <button class="btn btn-neutral">
                                        Tidak
                                    </button>
                                </form>

                                <form id="delete-mk-form-{{ $mk->kodemk }}"
                                      action="{{ route('mk.destroy', $mk->kodemk) }}"
                                      method="POST">

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
                <td colspan="8" class="text-center">
                    Tidak ada data
                </td>
            </tr>
        @endforelse
            <td>{{$mks->links()}}</td>
        </tbody>

    </table>

</div>

</x-layout>