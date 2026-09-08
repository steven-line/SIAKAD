    <x-layout title="Data Mata Kuliah">

<div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100 p-4">

    {{-- ==========================================================
         HEADER
    =========================================================== --}}

    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">

        <h2 class="text-2xl font-bold">
            Data Mata Kuliah
        </h2>

        <a class="btn btn-primary text-white"
           href="{{ route('mk.create') }}">
            + Create Mata Kuliah
        </a>

    </div>


    {{-- ==========================================================
         NOTIFIKASI SUCCESS
    =========================================================== --}}

    @if (session('success'))

        <div class="alert alert-success mb-4">

            <span>
                {{ session('success') }}
            </span>

        </div>

    @endif


    {{-- ==========================================================
         NOTIFIKASI ERROR
    =========================================================== --}}

    @if (session('error'))

        <div class="alert alert-error mb-4">

            <span>
                {{ session('error') }}
            </span>

        </div>

    @endif


    {{-- ==========================================================
         VALIDATION ERROR
    =========================================================== --}}

    @if ($errors->any())

        <div class="alert alert-error mb-4">

            <ul>

                @foreach ($errors->all() as $error)

                    <li>
                        • {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- ==========================================================
         SEARCH
    =========================================================== --}}

    <form action="{{ route('mk.index') }}"
          method="GET"
          class="flex flex-wrap gap-2 mb-5">

        <input
            type="text"
            name="search"
            value="{{ $search ?? '' }}"
            class="input input-bordered"
            placeholder="Cari kode atau nama mata kuliah..."
        >

        <button type="submit"
                class="btn btn-primary">

            Cari

        </button>

        @if (!empty($search))

            <a href="{{ route('mk.index') }}"
               class="btn btn-neutral">

                Reset

            </a>

        @endif

    </form>


    {{-- ==========================================================
         UPLOAD
    =========================================================== --}}

    <div class="flex flex-wrap items-center gap-2 mb-5">

        <form action="{{ route('mk.upload') }}"
              method="POST"
              enctype="multipart/form-data"
              class="flex flex-wrap items-center gap-2">

            @csrf

            <input
                type="file"
                name="file"
                accept=".csv,.xlsx,.xls"
                class="file-input file-input-bordered"
            >

            <button type="submit"
                    class="btn btn-primary">

                Upload File

            </button>

        </form>


        <a href="{{ asset('document/template_import_mk.xlsx') }}"
           download
           class="btn btn-success">

            Download Template

        </a>

    </div>


    {{-- ==========================================================
         TABLE
    =========================================================== --}}

    <div class="overflow-x-auto">

        <table class="table table-zebra">

            <thead class="bg-blue-500 text-white">

                <tr>

                    <th>No</th>

                    <th>Kode MK</th>

                    <th>Nama</th>

                    <th>Jenis MK</th>

                    <th>Periode Input</th>

                    <th>Jenjang Didik</th>

                    <th>Kode Kurikulum</th>

                    <th>Aktif</th>

                    <th colspan="3"
                        class="text-center">

                        Aksi

                    </th>

                </tr>

            </thead>


            <tbody>

            @forelse ($mks as $mk)

                <tr>

                    {{-- NO --}}

                    <td>
                        {{ $mks->firstItem() + $loop->index }}
                    </td>


                    {{-- KODE MK --}}

                    <td class="font-medium">
                        {{ $mk->kodemk }}
                    </td>


                    {{-- NAMA --}}

                    <td>
                        {{ $mk->nama }}
                    </td>


                    {{-- ==================================================
                         JENIS MK
                    =================================================== --}}

                    <td>

                        @switch($mk->jenis_mk)

                            @case('mk_fakultas')

                                <span class="badge badge-primary">
                                    MK Fakultas
                                </span>

                                @break


                            @case('mk_umum')

                                <span class="badge badge-info">
                                    MK Umum
                                </span>

                                @break


                            @case('mk_prodi')

                                <span class="badge badge-success">
                                    MK Prodi
                                </span>

                                @break


                            @case('mk_khusus')

                                <span class="badge badge-warning">
                                    MK Khusus
                                </span>

                                @break


                            @default

                                <span class="badge badge-error">
                                    Tidak diketahui
                                </span>

                        @endswitch

                    </td>


                    {{-- ==================================================
                         PERIODE INPUT
                    =================================================== --}}

                    <td>

                        @if ($mk->periode_input === 'khusus')

                            <span class="badge badge-warning">
                                Khusus
                            </span>

                        @elseif ($mk->periode_input === 'normal')

                            <span class="badge badge-info">
                                Normal
                            </span>

                        @else

                            <span class="badge badge-error">
                                Tidak diketahui
                            </span>

                        @endif

                    </td>


                    {{-- JENJANG DIDIK --}}

                    <td>
                        {{ $mk->nm_jenj_didik }}
                    </td>


                    {{-- KURIKULUM --}}

                    <td>
                        {{ $mk->kode_kurikulum }}
                    </td>


                    {{-- ==================================================
                         AKTIF
                    =================================================== --}}

                    <td>

                        @if ($mk->aktif)

                            <span class="badge badge-success">
                                Aktif
                            </span>

                        @else

                            <span class="badge badge-error">
                                Tidak Aktif
                            </span>

                        @endif

                    </td>


                    {{-- ==================================================
                         DETAIL
                    =================================================== --}}

                    <td>

                        <a href="{{ route('mk.show', $mk->kodemk) }}"
                           class="btn btn-soft btn-primary">

                            Detail

                        </a>

                    </td>


                    {{-- ==================================================
                         EDIT
                    =================================================== --}}

                    <td>

                        <a href="{{ route('mk.edit', $mk->kodemk) }}"
                           class="btn btn-soft btn-warning">

                            Edit

                        </a>

                    </td>


                    {{-- ==================================================
                         DELETE
                    =================================================== --}}

                    <td>

                        <button
                            type="button"
                            class="btn btn-soft btn-error"
                            onclick="deleteBox_{{ $mk->kodemk }}.showModal()">

                            Delete

                        </button>


                        <dialog
                            id="deleteBox_{{ $mk->kodemk }}"
                            class="modal modal-bottom sm:modal-middle">

                            <div class="modal-box">

                                <h3 class="text-lg font-bold">

                                    Peringatan Penghapusan

                                </h3>


                                <p class="py-4">

                                    Apakah Anda yakin ingin
                                    menghapus mata kuliah

                                    <strong>
                                        {{ $mk->nama }}
                                    </strong>?

                                </p>


                                <div class="modal-action">

                                    {{-- TIDAK --}}

                                    <form method="dialog">

                                        <button class="btn btn-neutral">

                                            Tidak

                                        </button>

                                    </form>


                                    {{-- YA --}}

                                    <form
                                        action="{{ route('mk.destroy', $mk->kodemk) }}"
                                        method="POST">

                                        @csrf

                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-error">

                                            Ya, Hapus

                                        </button>

                                    </form>

                                </div>

                            </div>

                        </dialog>

                    </td>

                </tr>


            @empty

                <tr>

                    <td colspan="11"
                        class="text-center py-8">

                        Tidak ada data mata kuliah.

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>


    {{-- ==========================================================
         PAGINATION
    =========================================================== --}}

    <div class="mt-5">

        {{ $mks->links() }}

    </div>

</div>

</x-layout>
