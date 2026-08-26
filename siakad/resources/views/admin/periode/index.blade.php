<x-layout title="Data Periode">

<div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100">

    <div class="p-4">

        {{-- CREATE --}}
        <a class="btn btn-primary text-white mb-6"
           href="{{ route('periode.create') }}">
            + Create Periode
        </a>

        <table class="table">

            <thead class="bg-blue-500 text-white">
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Id</th>
                    <th>Tahun Ajaran</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Selesai</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th class="text-center">Semester</th>
                    <th class="text-center" colspan="4">Aksi</th>
                </tr>
            </thead>

            <tbody>

            @forelse($periodes as $periode)

                @php
                    $isGanjilActive = $periode->semesters
                        ->where('jenis', 'Ganjil')
                        ->where('aktif', true)
                        ->count() > 0;

                    $isGenapActive = $periode->semesters
                        ->where('jenis', 'Genap')
                        ->where('aktif', true)
                        ->count() > 0;
                @endphp

                <tr class="hover">

                    {{-- NO --}}
                    <td class="text-center font-medium">
                        {{ $periodes->firstItem() + $loop->index }}
                    </td>

                    {{-- ID --}}
                    <td class="text-center">
                        <span class="badge badge-neutral">
                            {{ $periode->id }}
                        </span>
                    </td>

                    {{-- TAHUN AJARAN --}}
                    <td class="font-semibold">
                        {{ $periode->tahun_ajaran }}
                    </td>

                    {{-- TANGGAL MULAI --}}
                    <td>
                        {{ $periode->tanggal_mulai }}
                    </td>

                    {{-- TANGGAL SELESAI --}}
                    <td>
                        {{ $periode->tanggal_selesai }}
                    </td>

                    {{-- CREATED AT --}}
                    <td class="text-sm">
                        {{ $periode->created_at }}
                    </td>

                    {{-- UPDATED AT --}}
                    <td class="text-sm">
                        {{ $periode->updated_at }}
                    </td>


                    {{-- ========================= --}}
                    {{-- SEMESTER --}}
                    {{-- ========================= --}}
                    <td>

                        <div class="flex flex-col gap-2 min-w-[100px]">

                            {{-- GANJIL --}}
                            <button type="button"
                                    class="btn btn-sm w-full
                                    {{ !$periode->aktif
                                        ? 'btn-disabled bg-gray-300 text-gray-500'
                                        : ($isGanjilActive
                                            ? 'btn-success text-white'
                                            : 'btn-soft btn-info') }}"
                                    {{ !$periode->aktif ? 'disabled' : '' }}
                                    onclick="switchGanjil_{{ $periode->id }}.showModal()">

                                <span class="flex items-center justify-center gap-2">
                                    Ganjil

                                    @if($isGanjilActive)
                                        <span>✓</span>
                                    @endif
                                </span>

                            </button>


                            {{-- MODAL GANJIL --}}
                            <dialog id="switchGanjil_{{ $periode->id }}"
                                    class="modal modal-bottom sm:modal-middle">

                                <div class="modal-box">

                                    <h3 class="text-lg font-bold">
                                        Ganti Semester
                                    </h3>

                                    <p class="py-4">
                                        Yakin ingin mengaktifkan semester
                                        <strong>Ganjil</strong>
                                        untuk periode
                                        <strong>{{ $periode->tahun_ajaran }}</strong>?
                                    </p>

                                    <div class="modal-action">

                                        <form method="dialog">
                                            <button class="btn btn-neutral">
                                                Batal
                                            </button>
                                        </form>

                                        <form action="{{ route('periode.aktifkan', [$periode->id, 'Ganjil']) }}"
                                              method="POST">

                                            @csrf

                                            <button type="submit"
                                                    class="btn btn-primary">

                                                Ya, Aktifkan

                                            </button>

                                        </form>

                                    </div>

                                </div>

                            </dialog>


                            {{-- GENAP --}}
                            <button type="button"
                                    class="btn btn-sm w-full
                                    {{ !$periode->aktif
                                        ? 'btn-disabled bg-gray-300 text-gray-500'
                                        : ($isGenapActive
                                            ? 'btn-success text-white'
                                            : 'btn-soft btn-info') }}"
                                    {{ !$periode->aktif ? 'disabled' : '' }}
                                    onclick="switchGenap_{{ $periode->id }}.showModal()">

                                <span class="flex items-center justify-center gap-2">
                                    Genap

                                    @if($isGenapActive)
                                        <span>✓</span>
                                    @endif
                                </span>

                            </button>


                            {{-- MODAL GENAP --}}
                            <dialog id="switchGenap_{{ $periode->id }}"
                                    class="modal modal-bottom sm:modal-middle">

                                <div class="modal-box">

                                    <h3 class="text-lg font-bold">
                                        Ganti Semester
                                    </h3>

                                    <p class="py-4">
                                        Yakin ingin mengaktifkan semester
                                        <strong>Genap</strong>
                                        untuk periode
                                        <strong>{{ $periode->tahun_ajaran }}</strong>?
                                    </p>

                                    <div class="modal-action">

                                        <form method="dialog">
                                            <button class="btn btn-neutral">
                                                Batal
                                            </button>
                                        </form>

                                        <form action="{{ route('periode.aktifkan', [$periode->id, 'Genap']) }}"
                                              method="POST">

                                            @csrf

                                            <button type="submit"
                                                    class="btn btn-primary">

                                                Ya, Aktifkan

                                            </button>

                                        </form>

                                    </div>

                                </div>

                            </dialog>

                        </div>

                    </td>


                    {{-- ========================= --}}
                    {{-- DETAIL --}}
                    {{-- ========================= --}}
                    <td>

                        <a href="{{ route('periode.show', $periode->id) }}"
                           class="btn btn-sm btn-soft btn-primary w-full">

                            Detail

                        </a>

                    </td>


                    {{-- ========================= --}}
                    {{-- AKTIFKAN --}}
                    {{-- ========================= --}}
                    <td>

                        <form action="{{ route('periode.periodeAktif', $periode->id) }}"
                              method="POST">

                            @csrf

                            <button type="submit"
                                    class="btn btn-sm w-full
                                    {{ $periode->aktif
                                        ? 'btn-success text-white'
                                        : 'btn-soft btn-info' }}"
                                    {{ $periode->aktif ? 'disabled' : '' }}>

                                @if($periode->aktif)
                                    ✓ Aktif
                                @else
                                    Aktifkan
                                @endif

                            </button>

                        </form>

                    </td>


                    {{-- ========================= --}}
                    {{-- SETUP --}}
                    {{-- ========================= --}}
                    <td>

                        <a href="{{ route('metaperiode.index', $periode->id) }}"
                           class="btn btn-sm btn-soft btn-warning w-full">

                            ⚙ Setup

                        </a>

                    </td>


                    {{-- ========================= --}}
                    {{-- DELETE --}}
                    {{-- ========================= --}}
                    <td>

                        <button type="button"
                                class="btn btn-sm btn-soft btn-error w-full"
                                onclick="deleteBox_{{ $periode->id }}.showModal()">

                            Delete

                        </button>


                        {{-- MODAL DELETE --}}
                        <dialog id="deleteBox_{{ $periode->id }}"
                                class="modal modal-bottom sm:modal-middle">

                            <div class="modal-box">

                                <h3 class="text-lg font-bold">
                                    Peringatan Penghapusan
                                </h3>

                                <p class="py-4">
                                    Apakah Anda yakin ingin menghapus periode
                                    <strong>{{ $periode->tahun_ajaran }}</strong>?
                                </p>

                                <div class="modal-action">

                                    {{-- BATAL --}}
                                    <form method="dialog">

                                        <button class="btn btn-neutral">
                                            Tidak
                                        </button>

                                    </form>


                                    {{-- DELETE --}}
                                    <form method="POST"
                                          action="{{ route('periode.destroy', $periode->id) }}">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-error text-white">

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

                    <td colspan="12"
                        class="text-center py-8">

                        <div class="flex flex-col items-center gap-2">

                            <span class="text-lg font-semibold">
                                Tidak ada data periode
                            </span>

                            <span class="text-sm opacity-60">
                                Belum ada periode yang tersedia.
                            </span>

                        </div>

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>


        {{-- PAGINATION --}}
        <div class="mt-4">

            {{ $periodes->links() }}

        </div>

    </div>

</div>

</x-layout>