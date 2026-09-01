<x-layout title="index">

<div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100">

<a class="btn btn-primary text-white mb-6"
   href="{{ route('mk.create') }}">
    Create Mata Kuliah
</a>

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

{{-- SEARCH --}}
<form action="{{ route('mk.index') }}"
      method="GET"
      class="mb-5">

    <input type="text"
           name="search"
           value="{{ $search ?? '' }}"
           class="file-input px-2"
           placeholder="Cari Matkul...">

    <button type="submit"
            class="btn btn-primary">
        Cari
    </button>

</form>

{{-- UPLOAD --}}
<form action="{{ route('mk.upload') }}"
      class="mb-10"
      method="POST"
      enctype="multipart/form-data">

    @csrf

    <input type="file"
           name="file"
           accept=".csv, .xlsx, .xls"
           class="file-input">

    <input type="submit"
           value="Upload File"
           class="btn btn-primary">

</form>

<a href="{{ asset('document/template_import_mk.xlsx') }}"
   download
   class="btn btn-success mb-5">
    Download Template
</a>


<table class="table">

    <thead class="bg-blue-500 text-white">

        <tr>
            <th>No</th>
            <th>Kode MK</th>
            <th>Nama</th>
            <th>Jenis</th>
            <th>Nama Jenjang Didik</th>
            <th>Kode Kurikulum</th>
            <th>Aktif</th>
            <th colspan="3">Aksi</th>
        </tr>

    </thead>

    <tbody>

    @forelse ($mks as $mk)

        <tr>

            <td>
                {{ $mks->firstItem() + $loop->index }}
            </td>

            <td class="text-center">
                {{ $mk->kodemk }}
            </td>

            <td class="text-center">
                {{ $mk->nama }}
            </td>

            {{-- JENIS --}}
            <td class="text-center">

                @if ($mk->jenis === 'khusus')

                    <span class="badge badge-warning">
                        Khusus
                    </span>

                @else

                    <span class="badge badge-info">
                        Normal
                    </span>

                @endif

            </td>

            <td class="text-center">
                {{ $mk->nm_jenj_didik }}
            </td>

            <td class="text-center">
                {{ $mk->kode_kurikulum }}
            </td>

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


                            <form
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

            <td colspan="10"
                class="text-center">

                Tidak ada data

            </td>

        </tr>

    @endforelse

    </tbody>

</table>


{{-- PAGINATION --}}
<div class="mt-4">
    {{ $mks->links() }}
</div>

</div>

</x-layout>
