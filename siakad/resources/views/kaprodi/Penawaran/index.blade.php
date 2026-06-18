<x-layout title="Data Penawaran">

<div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100">

    <div class="p-4">
        <a class="btn btn-primary text-white mb-4"
           href="{{route('penawaran.create')}}">
            Create Penawaran
        </a>
    </div>

    <table class="table table-zebra">

        <thead class="bg-blue-500 text-white">
            <tr>
                <th>No</th>
                <th>MBKM</th>
                <th>Kode MK</th>
                <th>Semester</th>
                <th>Periode</th>
                <th>Dosen</th>
                <th>Sesi</th>
                <th>Hari</th>
                <th>Jam</th>
                <th>Jurusan</th>
                <th>Pagu</th>
                <th>P/M</th>
                <th colspan="3" class="text-center">Aksi</th>
            </tr>
        </thead>

        <tbody>

            @forelse($penawarans as $penawaran)

            <tr>

                <td>
                    {{ $loop->iteration }}
                </td>

                <td>
                    @if($penawaran->MBKM)
                        <span class="badge badge-success">
                            Ya
                        </span>
                    @else
                        <span class="badge badge-error">
                            Tidak
                        </span>
                    @endif
                </td>

                <td>{{ $penawaran->kodemk }}</td>

                <td>{{ $penawaran->semester }}</td>

                <td>{{ $penawaran->periode }}</td>

                <td>{{ $penawaran->dosen }}</td>

                <td>{{ $penawaran->sesi }}</td>

                <td>{{ $penawaran->hari }}</td>

                <td>
                    {{ \Carbon\Carbon::parse($penawaran->mulaipukul)->format('H:i') }}
                    -
                    {{ \Carbon\Carbon::parse($penawaran->selesaipukul)->format('H:i') }}
                </td>

                <td>{{ $penawaran->jurusan }}</td>

                <td>{{ $penawaran->pagu }}</td>

                <td>{{ $penawaran->pataum }}</td>

                {{-- DETAIL --}}
                <td>
                    <a class="btn btn-soft btn-info"
                       href="{{route('penawaran.show', $penawaran->recno )}}">
                        Detail
                    </a>
                </td>

                {{-- EDIT --}}
                <td>
                    <a class="btn btn-soft btn-warning"
                       href="{{ route('penawaran.edit', $penawaran->recno) }}">
                        Edit
                    </a>
                </td>

                {{-- DELETE --}}
                <td>

                    <button class="btn btn-soft btn-error"
                        onclick="deleteBox_{{ $penawaran->recno }}.showModal()">
                        Delete
                    </button>

                    <dialog id="deleteBox_{{ $penawaran->recno }}"
                            class="modal modal-bottom sm:modal-middle">

                        <div class="modal-box">

                            <h3 class="text-lg font-bold">
                                Peringatan Penghapusan
                            </h3>

                            <p class="py-4">
                                Apakah Anda yakin ingin menghapus data penawaran ini?
                            </p>

                            <div class="modal-action">

                                <form method="dialog">
                                    <button
                                        class="btn btn-primary"
                                        form="delete-penawaran-form-{{ $penawaran->recno }}">
                                        Ya
                                    </button>

                                    <button class="btn btn-neutral">
                                        Tidak
                                    </button>
                                </form>

                            </div>

                        </div>

                    </dialog>

                </td>

            </tr>

            <form
                id="delete-penawaran-form-{{ $penawaran->recno }}"
                action="{{ route('penawaran.destroy', $penawaran->recno) }}"
                method="POST">

                @csrf
                @method('DELETE')

            </form>

            @empty

            <tr>
                <td colspan="15" class="text-center">
                    Tidak ada data penawaran
                </td>
            </tr>

            @endforelse

        </tbody>

    </table>

</div>

</x-layout>