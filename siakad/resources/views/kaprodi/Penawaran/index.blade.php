<x-layout title="Data Penawaran">

    {{-- ALERT --}}
    @if(session('success'))
        <div class="alert alert-success mb-4">
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error mb-4">
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100">

        <div class="p-4">

            @php
                $metaPeriode = \App\Models\Metaperiode::first();

                $bolehInput =
                    $metaPeriode &&
                    $metaPeriode->input_penawaran_mulai &&
                    $metaPeriode->input_penawaran_selesai &&
                    now()->between(
                        $metaPeriode->input_penawaran_mulai,
                        $metaPeriode->input_penawaran_selesai
                    );
            @endphp

            @if($bolehInput)
                <a class="btn btn-primary text-white mb-4"
                   href="{{ route('penawaran.create') }}">
                    Create Penawaran
                </a>
            @else
                <button class="btn btn-disabled mb-4">
                    Create Penawaran
                </button>
            @endif

        </div>

        <table class="table table-zebra">

            <thead class="bg-blue-500 text-white">
                <tr>
                    <th>No</th>
                    <th>MBKM</th>
                    <th>Kode MK</th>
                    <th>Semester</th>
                    <th>Dosen</th>
                    <th>Sesi</th>
                    <th>Hari</th>
                    <th>Jam</th>
                    <th>Pagu</th>
                    <th>P/M</th>
                    <th colspan="3" class="text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>

            @forelse($penawarans as $penawaran)

                <tr>

                    <td>
                        {{ $loop->iteration + ($penawarans->firstItem() - 1) }}
                    </td>

                    <td>
                        @if($penawaran->MBKM)
                            <span class="badge badge-success">Ya</span>
                        @else
                            <span class="badge badge-error">Tidak</span>
                        @endif
                    </td>

                    <td>
                        {{ $penawaran->mk->kodemk ?? $penawaran->kodemk }}
                    </td>

                    <td>
                        @if($penawaran->semesterRelasi)
                            {{ $penawaran->semesterRelasi->nama }}
                            -
                            {{ $penawaran->semesterRelasi->jenis }}
                        @else
                            <span class="text-red-500">Belum ada semester</span>
                        @endif
                    </td>

                    <td>
                        {{ $penawaran->dosenRelasi->nama ?? $penawaran->dosen }}
                    </td>

                    <td>
                        Sesi {{ $penawaran->sesi }}
                    </td>

                    <td>
                        {{ $penawaran->hari }}
                    </td>

                    <td>
                        {{ \Carbon\Carbon::parse($penawaran->mulaipukul)->format('H:i') }}
                        -
                        {{ \Carbon\Carbon::parse($penawaran->selesaipukul)->format('H:i') }}
                    </td>

                    <td>
                        {{ $penawaran->pagu }}
                    </td>

                    <td>
                        {{ $penawaran->pataum }}
                    </td>

                    {{-- DETAIL --}}
                    <td>
                        <a class="btn btn-soft btn-info"
                           href="{{ route('penawaran.show', $penawaran->recno) }}">
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
                            onclick="document.getElementById('deleteBox_{{ $penawaran->recno }}').showModal()">
                            Delete
                        </button>

                        <dialog id="deleteBox_{{ $penawaran->recno }}"
                                class="modal modal-bottom sm:modal-middle">

                            <div class="modal-box">

                                <h3 class="text-lg font-bold">
                                    Peringatan Penghapusan
                                </h3>

                                <p class="py-4">
                                    Apakah Anda yakin ingin menghapus data ini?
                                </p>

                                <div class="modal-action">

                                    <form method="dialog">
                                        <button class="btn btn-neutral">
                                            Tidak
                                        </button>
                                    </form>

                                    <form action="{{ route('penawaran.destroy', $penawaran->recno) }}"
                                          method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-error">
                                            Delete
                                        </button>
                                    </form>

                                </div>

                            </div>

                        </dialog>

                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="12" class="text-center text-gray-400">
                        Tidak ada data penawaran
                    </td>
                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

</x-layout>