<x-layout title="Penawaran Mata Kuliah Umum">

<div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100">

    <div class="p-4 flex justify-between items-center">

        <div>
            <h2 class="text-xl font-bold">
                Penawaran Mata Kuliah Umum
            </h2>

            <p class="text-sm text-gray-500">
                Penawaran yang dibuat di halaman ini akan digunakan oleh seluruh program studi.
            </p>
        </div>

        <a class="btn btn-primary text-white"
           href="{{ route('admin.penawaran.create') }}">
            + Tambah Penawaran Umum
        </a>

    </div>
    <form action="{{route('admin.penawaran.index')}}" method="GET" class="mb-5">
        <input type="text" name="search" value='{{$search ?? ''}}' class="file-input px-2" placeholder="Cari Penawaran...">
        <button type="submit" class="btn btn-primary">Cari</button>
    </form>
    @if(session('success'))
        <div class="alert alert-success mx-4 mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error mx-4 mb-4">
            {{ session('error') }}
        </div>
    @endif

    <table class="table table-zebra">

        <thead class="bg-blue-500 text-white">

        <tr>

            <th>No</th>
            <th>Jenis</th>
            <th>MBKM</th>
            <th>Kode MK</th>
            <th>Nama Mata Kuliah</th>
            <th>Semester</th>
            <th>Dosen</th>
            <th>Hari</th>
            <th>Jam</th>
            <th>Pagu</th>
            <th>Kelas</th>

            <th colspan="3" class="text-center">
                Aksi
            </th>

        </tr>

        </thead>

        <tbody>

        @forelse($penawarans as $penawaran)

            <tr>

                <td>
                    {{ $loop->iteration + ($penawarans->firstItem()-1) }}
                </td>

                <td>

                    <span class="badge badge-info">

                        UMUM

                    </span>

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

                <td>

                    {{ $penawaran->mk->kodemk }}

                </td>

                <td>

                    {{ $penawaran->mk->nama }}

                </td>

                <td>

                    {{ $penawaran->semesterRelasi->nama }}
                    -
                    {{ $penawaran->semesterRelasi->jenis }}

                </td>

                <td>

                    {{ $penawaran->dosenRelasi->nama }}

                </td>

                <td>

                    {{ $penawaran->hari }}

                </td>

                <td>

                    {{ $penawaran->mulaipukul->format('H:i') }}
                    -
                    {{ $penawaran->selesaipukul->format('H:i') }}

                </td>

                <td>

                    {{ $penawaran->pagu }}

                </td>

                <td>

                    {{ $penawaran->pataum }}

                </td>

                <td>

                    <a
                        href="{{ route('admin.penawaran.show',$penawaran->recno) }}"
                        class="btn btn-info btn-soft">

                        Detail

                    </a>

                </td>

                <td>

                    <a
                        href="{{ route('admin.penawaran.edit',$penawaran->recno) }}"
                        class="btn btn-warning btn-soft">

                        Edit

                    </a>

                </td>

                <td>

                    <button
                        class="btn btn-error btn-soft"
                        onclick="document.getElementById('delete{{ $penawaran->recno }}').showModal()">

                        Delete

                    </button>

                    <dialog
                        id="delete{{ $penawaran->recno }}"
                        class="modal">

                        <div class="modal-box">

                            <h3 class="font-bold text-lg">

                                Hapus Penawaran

                            </h3>

                            <p class="py-4">

                                Yakin ingin menghapus penawaran
                                <strong>

                                    {{ $penawaran->mk->nama }}

                                </strong>
                                ?

                            </p>

                            <div class="modal-action">

                                <form method="dialog">

                                    <button class="btn">

                                        Batal

                                    </button>

                                </form>

                                <form
                                    method="POST"
                                    action="{{ route('admin.penawaran.destroy',$penawaran->recno) }}">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        class="btn btn-error">

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

                <td colspan="14"
                    class="text-center text-gray-500">

                    Belum ada penawaran mata kuliah umum.

                </td>

            </tr>

        @endforelse

        </tbody>

    </table>

    <div class="p-4">

        {{ $penawarans->links() }}

    </div>

</div>

</x-layout>