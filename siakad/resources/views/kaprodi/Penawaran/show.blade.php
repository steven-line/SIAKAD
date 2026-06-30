<x-layout>
<div class="max-w-4xl mx-auto p-6 text-white">

    <h1 class="text-2xl font-bold mb-6">
        Detail Penawaran Mata Kuliah
    </h1>

    <div class="bg-gray-800 rounded-lg shadow p-6">

        <div class="grid grid-cols-2 gap-5">

            {{-- KODE MK --}}
            <div>
                <label class="text-gray-400">Kode MK</label>
                <p>{{ $penawaran->mk->kodemk ?? '-' }}</p>
            </div>

            {{-- NAMA MK --}}
            <div>
                <label class="text-gray-400">Mata Kuliah</label>
                <p>{{ $penawaran->mk->nama ?? '-' }}</p>
            </div>

            {{-- SKS --}}
            <div>
                <label class="text-gray-400">SKS</label>
                <p>{{ $penawaran->mk->sks ?? '-' }}</p>
            </div>

            {{-- SEMESTER --}}
            <div>
                <label class="text-gray-400">Semester</label>
                <p>
                    {{ $penawaran->semesterRelasi->nama }} - 
                    {{ $penawaran->semesterRelasi->jenis ?? '-' }}

                </p>
            </div>

            {{-- TAHUN AJARAN --}}
            <div>
                <label class="text-gray-400">Tahun Ajaran</label>
                <p>
                    {{ $penawaran->semesterRelasi->periode->tahun_ajaran ?? '-' }}
                </p>
            </div>

            {{-- DOSEN --}}
            <div>
                <label class="text-gray-400">Dosen</label>
                <p>{{ $penawaran->dosenRelasi->nama ?? '-' }}</p>
            </div>

            {{-- PRODI --}}
            <div>
                <label class="text-gray-400">Prodi</label>
                <p>{{ $penawaran->dosenRelasi->prodi ?? '-' }}</p>
            </div>

            {{-- HARI --}}
            <div>
                <label class="text-gray-400">Hari</label>
                <p>{{ $penawaran->hari }}</p>
            </div>

            {{-- SESI --}}
            <div>
                <label class="text-gray-400">Sesi</label>
                <p>
                    {{ $penawaran->sesi == 1 ? 'Sesi 1 (Pagi)' : 'Sesi 2 (Malam)' }}
                </p>
            </div>

            {{-- JAM MULAI --}}
            <div>
                <label class="text-gray-400">Jam Mulai</label>
                <p>
                    {{ \Carbon\Carbon::parse($penawaran->mulaipukul)->format('H:i') }}
                </p>
            </div>

            {{-- JAM SELESAI --}}
            <div>
                <label class="text-gray-400">Jam Selesai</label>
                <p>
                    {{ \Carbon\Carbon::parse($penawaran->selesaipukul)->format('H:i') }}
                </p>
            </div>

            {{-- PAGU --}}
            <div>
                <label class="text-gray-400">Pagu</label>
                <p>{{ $penawaran->pagu }}</p>
            </div>

            {{-- KELAS --}}
            <div>
                <label class="text-gray-400">Kelas</label>
                <p>{{ $penawaran->pataum == 'P' ? 'Pagi' : 'Malam' }}</p>
            </div>

            {{-- MBKM --}}
            <div>
                <label class="text-gray-400">MBKM</label>
                <p>
                    @if($penawaran->MBKM)
                        <span class="badge badge-success">Ya</span>
                    @else
                        <span class="badge badge-error">Tidak</span>
                    @endif
                </p>
            </div>

            {{-- KETERANGAN --}}
            <div class="col-span-2">
                <label class="text-gray-400">Keterangan</label>
                <p>{{ $penawaran->keterangan ?: '-' }}</p>
            </div>

        </div>

        <div class="mt-8">
            <a href="{{ route('penawaran.index') }}"
               class="btn btn-primary">
                Kembali
            </a>
        </div>

    </div>

</div>
</x-layout>