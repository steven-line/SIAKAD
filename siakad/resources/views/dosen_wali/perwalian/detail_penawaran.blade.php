<x-layout title="KRS UWIKA">

    <div class="container mx-auto p-4">

        <h1 class="text-2xl font-bold mb-4">
            Informasi Mata Kuliah
        </h1>

        {{-- Informasi Detail Mata Kuliah --}}
        <div class="mb-6 p-4 bg-base-100 rounded-lg shadow">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div><strong>Kode MK:</strong> {{ $penawaran->kodemk }}</div>
                <div><strong>Mata Kuliah:</strong> {{ $penawaran->mk->nama }}</div>

                <div><strong>Dosen:</strong> {{ $penawaran->dosenRelasi->nama ?? '-' }}</div>
                <div><strong>Hari:</strong> {{ $penawaran->hari }}</div>

                <div><strong>Jam Mulai:</strong> {{ $penawaran->mulaipukul->format('H:i') }}</div>
                <div><strong>Jam Selesai:</strong> {{ $penawaran->selesaipukul->format('H:i') }}</div>

                <div><strong>SKS:</strong> {{ $penawaran->mk->sks }}</div>
                <div><strong>Semester:</strong> {{ $penawaran->semester->nama ?? '-' }}</div>

                <div><strong>Keterangan :</strong> {{ $penawaran->keterangan ?? '-' }}</div>
                <div><strong>Periode :</strong> {{ $penawaran->periode ?? 'GENAP / 2025-2026' }}</div>

                {{-- Tombol Aksi --}}
                <div class="md:col-span-2">
                    <strong>Aksi Dosen Wali :</strong>

                    <div class="mt-2">

                        @if($sudahAmbil)

                            <form action="{{ route('perwalian.penawaran.batal', [$mahasiswa->nrp, $penawaran->recno]) }}"
                                  method="POST">
                                @csrf
                                @method('DELETE')

                                <button class="btn btn-error">
                                    Batalkan KRS Mahasiswa
                                </button>
                            </form>

                        @else

                            <form action="{{ route('perwalian.penawaran.ambil', [$mahasiswa->nrp, $penawaran->recno]) }}"
                                  method="POST">
                                @csrf

                                <button class="btn btn-primary">
                                    Tambahkan ke KRS Mahasiswa
                                </button>
                            </form>

                        @endif

                    </div>
                </div>

            </div>

        </div>

        {{-- Alert --}}
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

        {{-- Daftar Mahasiswa --}}
        <h2 class="text-xl font-semibold mb-2">
            Daftar Mahasiswa Peserta
        </h2>

        <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100">
            <table class="table w-full">

                <thead class="bg-blue-500 text-white">
                    <tr>
                        <th>No</th>
                        <th>NRP</th>
                        <th>Nama</th>
                        <th>Status</th>
                        <th>Tanggal Registrasi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse ($registrasis as $registrasi)

                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $registrasi->nrp }}</td>
                            <td>{{ $registrasi->mahasiswa->biodata->nama ?? '-' }}</td>
                            <td>{{ $registrasi->status }}</td>
                            <td>{{ $registrasi->tanggal }}</td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="5" class="text-center py-4">
                                Belum ada mahasiswa terdaftar
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>
        </div>

        {{-- Tombol Kembali --}}
        <div class="mt-6">
            <a href="{{ route('perwalian.penawaran', $mahasiswa->nrp) }}"
               class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md shadow">
                ← Kembali
            </a>
        </div>

    </div>

</x-layout>