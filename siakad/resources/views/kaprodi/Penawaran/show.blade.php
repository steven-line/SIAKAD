<x-layout>
<div class="max-w-4xl mx-auto p-6 text-white">

    <h1 class="text-2xl font-bold mb-6">
        Detail Penawaran Mata Kuliah
    </h1>

    <div class="bg-gray-800 rounded-lg shadow p-6">

        <div class="grid grid-cols-2 gap-4">

            <div>
                <label class="text-gray-400">Kode MK</label>
                <p>{{ $penawaran->kodemk }}</p>
            </div>

            <div>
                <label class="text-gray-400">Mata Kuliah</label>
                <p>{{ $penawaran->matkul->namamk ?? '-' }}</p>
            </div>

            <div>
                <label class="text-gray-400">SKS</label>
                <p>{{ $penawaran->matkul->sks ?? '-' }}</p>
            </div>

            <div>
                <label class="text-gray-400">Semester</label>
                <p>{{ $penawaran->semester }}</p>
            </div>

            <div>
                <label class="text-gray-400">Periode</label>
                <p>{{ $penawaran->periode }}</p>
            </div>

            <div>
                <label class="text-gray-400">Dosen</label>
                <p>{{ $penawaran->dosenRelasi->nama ?? '-' }}</p>
            </div>

            <div>
                <label class="text-gray-400">Hari</label>
                <p>{{ $penawaran->hari }}</p>
            </div>

            <div>
                <label class="text-gray-400">Sesi</label>
                <p>{{ $penawaran->sesi }}</p>
            </div>

            <div>
                <label class="text-gray-400">Jam Mulai</label>
                <p>{{ $penawaran->mulaipukul }}</p>
            </div>

            <div>
                <label class="text-gray-400">Jam Selesai</label>
                <p>{{ $penawaran->selesaipukul }}</p>
            </div>

            <div>
                <label class="text-gray-400">Jurusan</label>
                <p>{{ $penawaran->jurusanRelasi->nama_jurusan ?? $penawaran->jurusan }}</p>
            </div>

            <div>
                <label class="text-gray-400">Pagu</label>
                <p>{{ $penawaran->pagu }}</p>
            </div>

            <div>
                <label class="text-gray-400">P/A/U/M</label>
                <p>{{ $penawaran->pataum }}</p>
            </div>

            <div>
                <label class="text-gray-400">MBKM</label>
                <p>{{ $penawaran->MBKM ? 'Ya' : 'Tidak' }}</p>
            </div>

            <div class="col-span-2">
                <label class="text-gray-400">Keterangan</label>
                <p>{{ $penawaran->keterangan ?: '-' }}</p>
            </div>

        </div>

        <div class="mt-6">
            <a
                href="{{ route('penawaran.index') }}"
                class="bg-blue-600 px-4 py-2 rounded"
            >
                Kembali
            </a>
        </div>

    </div>
</div>
</x-layout>