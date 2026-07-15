<x-layout title="KRS UWIKA">
    @if($statusBlokir === 'BLOKIR')
        <div role="alert" class="alert alert-error mb-6">
            <span>
                KRS anda terblokir, mohon hubungi bagian keuangan untuk menyelesaikan tunggakan.
            </span>
        </div>

    @else

        @if($statusBlokir === 'TERKUNCI')
            <div role="alert" class="alert alert-warning mb-6">
                <span>
                    KRS Anda sedang terkunci. Anda masih dapat melihat data, tetapi tidak dapat melakukan perubahan.
                </span>
            </div>
        @endif

<div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Informasi Mata Kuliah</h1>

        <!-- Informasi Detail Mata Kuliah + Tombol Aksi -->
        <div class="mb-6 p-4 bg-base-100 rounded-lg shadow">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div><strong>Kode MK:</strong> {{ $penawaran->kodemk }}</div>
                <div><strong>Mata Kuliah:</strong> {{ $penawaran->mk->nama }}</div>
                <div><strong>Dosen:</strong> {{ $penawaran->dosenRelasi->nama ?? '-' }}</div>
                <div><strong>Hari:</strong> {{ $penawaran->hari }}</div>
                <div><strong>Jam Mulai:</strong> {{ $penawaran->mulaipukul->format('H:i') }}</div>
                <div><strong>Jam Selesai:</strong> {{ $penawaran->selesaipukul->format('H:i') }}</div>
                <div><strong>SKS:</strong> {{ $penawaran->mk->sks }}</div>
                <div><strong>Semester:</strong> {{ $penawaran->semester_id }}</div>
                <div><strong>Keterangan :</strong> {{ $penawaran->keterangan ?? '-' }}</div>
                <div><strong>Periode :</strong> {{ $penawaran->periode ?? 'GENAP / 2025-2026' }}</div>
                <div>
                    <strong>Aksi Anda :</strong>
                    
        @if($statusBlokir == 'TERKUNCI')

            <button class="btn btn-disabled">
                KRS Terkunci
            </button>

        @elseif($statusBlokir == 'BLOKIR')
            <button class="btn btn-disabled">
                KRS Diblokir
            </button>

        @elseif(in_array($statusBlokir, ['MENUNGGU_VALIDASI', 'DISETUJUI']))

            <button class="btn btn-disabled">
                Menunggu Validasi Dosen Wali
            </button>

        @else

            @if($sudahAmbil)

                <form action="{{ route('mahasiswa.mata_kuliah.batal', $penawaran->recno) }}" method="POST">
                    @csrf
                    @method('DELETE')

                    <button class="btn btn-error">
                        Batalkan KRS
                    </button>
                </form>

            @else

                <form action="{{ route('mahasiswa.mata_kuliah.daftar', $penawaran->recno) }}" method="POST">
                    @csrf

                    <button class="btn btn-primary">
                        Ambil KRS
                    </button>
                </form>

            @endif

        @endif
                </div>
            </div>
        </div>
        @if(session('success'))
    <div class="bg-green-500 text-white p-2">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="bg-red-500 text-white p-2">
        {{ session('error') }}
    </div>
@endif
        <!-- Tabel Daftar Mahasiswa -->
        <h2 class="text-xl font-semibold mb-2">Daftar Mahasiswa Peserta</h2>
        <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100">
            <table class="table w-full">
                <thead class="bg-blue-500 text-white">
                    <tr>
                        <th class="px-4 py-2">No</th>
                        <th class="px-4 py-2">NRP</th>
                        <th class="px-4 py-2">Nama</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Tanggal Registrasi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($registrasis as $registrasi)
                        <tr>
                            <td class="px-4 py-2">{{ $loop->index }}</td>
                            <td class="px-4 py-2">{{ $registrasi->nrp }}</td>
                            <td class="px-4 py-2">{{ $registrasi->mahasiswa->biodata->nama ?? null }}</td>
                            <td class="px-4 py-2">{{ $registrasi->status }}</td>
                            <td class="px-4 py-2">{{ $registrasi->tanggal }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center px-4 py-2">Belum ada mahasiswa terdaftar</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Tombol Kembali -->
        <div class="mt-6">
            <a href="{{ route('mahasiswa.penawaran.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md shadow">
                ← Kembali
            </a>
        </div>
    </div>
</x-layout>