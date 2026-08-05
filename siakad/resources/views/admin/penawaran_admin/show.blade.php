<x-layout title="Detail Penawaran Mata Kuliah Umum">

<div class="max-w-5xl mx-auto p-6">

    <div class="flex justify-between items-center mb-6">

        <div>

            <h1 class="text-2xl font-bold">
                Detail Penawaran Mata Kuliah Umum
            </h1>

            <p class="text-gray-500">
                Informasi lengkap penawaran mata kuliah umum.
            </p>

        </div>

        <a href="{{ route('admin.penawaran.index') }}"
           class="btn btn-neutral">
            ← Kembali
        </a>

    </div>

    <div class="card bg-base-100 shadow-xl border border-base-300">

        <div class="card-body">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Kode MK --}}
                <div>
                    <label class="font-semibold text-gray-500">
                        Kode Mata Kuliah
                    </label>

                    <div class="mt-1">
                        {{ $penawaran->mk->kodemk }}
                    </div>
                </div>

                {{-- Nama MK --}}
                <div>
                    <label class="font-semibold text-gray-500">
                        Nama Mata Kuliah
                    </label>

                    <div class="mt-1">
                        {{ $penawaran->mk->nama }}
                    </div>
                </div>

                {{-- SKS --}}
                <div>
                    <label class="font-semibold text-gray-500">
                        SKS
                    </label>

                    <div class="mt-1">
                        {{ $penawaran->mk->sks }}
                    </div>
                </div>

                {{-- Semester --}}
                <div>
                    <label class="font-semibold text-gray-500">
                        Semester
                    </label>

                    <div class="mt-1">

                        {{ $penawaran->semesterRelasi->nama }}
                        -
                        {{ $penawaran->semesterRelasi->periode->tahun_ajaran }}
                        -
                        {{ $penawaran->semesterRelasi->jenis }}

                    </div>
                </div>

                {{-- Dosen --}}
                <div>
                    <label class="font-semibold text-gray-500">
                        Dosen Pengampu
                    </label>

                    <div class="mt-1">

                        {{ $penawaran->dosenRelasi->nama }}

                    </div>
                </div>

                {{-- Hari --}}
                <div>
                    <label class="font-semibold text-gray-500">
                        Hari
                    </label>

                    <div class="mt-1">

                        {{ $penawaran->hari }}

                    </div>
                </div>

                {{-- Jam --}}
                <div>
                    <label class="font-semibold text-gray-500">
                        Jam Perkuliahan
                    </label>

                    <div class="mt-1">

                        {{ $penawaran->mulaipukul->format('H:i') }}
                        -
                        {{ $penawaran->selesaipukul->format('H:i') }}

                    </div>
                </div>

                {{-- Sesi --}}
                <div>
                    <label class="font-semibold text-gray-500">
                        Sesi
                    </label>

                    <div class="mt-1">

                        {{ $penawaran->sesi == 1 ? 'Sesi 1 (Pagi)' : 'Sesi 2 (Malam)' }}

                    </div>
                </div>

                {{-- Jenis Kelas --}}
                <div>
                    <label class="font-semibold text-gray-500">
                        Jenis Kelas
                    </label>

                    <div class="mt-1">

                        {{ $penawaran->pataum }}

                    </div>
                </div>

                {{-- Pagu --}}
                <div>
                    <label class="font-semibold text-gray-500">
                        Pagu Mahasiswa
                    </label>

                    <div class="mt-1">

                        {{ $penawaran->pagu }}

                    </div>
                </div>

                {{-- MBKM --}}
                <div>

                    <label class="font-semibold text-gray-500">
                        MBKM
                    </label>

                    <div class="mt-2">

                        @if($penawaran->MBKM)

                            <span class="badge badge-success">
                                Ya
                            </span>

                        @else

                            <span class="badge badge-error">
                                Tidak
                            </span>

                        @endif

                    </div>

                </div>

                {{-- Jenis Penawaran --}}
                <div>

                    <label class="font-semibold text-gray-500">
                        Jenis Penawaran
                    </label>

                    <div class="mt-2">

                        <span class="badge badge-info">

                            Mata Kuliah Umum

                        </span>

                    </div>

                </div>

            </div>

            {{-- Keterangan --}}
            <div class="mt-8">

                <label class="font-semibold text-gray-500">
                    Keterangan
                </label>

                <div class="mt-2 p-4 rounded-lg bg-base-200">

                    {{ $penawaran->keterangan ?: '-' }}

                </div>

            </div>

            <div class="card-actions justify-end mt-8">

                <a href="{{ route('admin.penawaran.edit',$penawaran->recno) }}"
                   class="btn btn-warning">

                    Edit Penawaran

                </a>

                <a href="{{ route('admin.penawaran.index') }}"
                   class="btn btn-neutral">

                    Kembali

                </a>

            </div>

        </div>

    </div>

</div>

</x-layout>