<x-layout title="Informasi Mata Kuliah">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">
            Informasi Mata Kuliah - {{ $mahasiswa->nama }}
        </h1>

   

        <!-- Tabel Daftar KRS -->
        <h2 class="text-xl font-semibold mb-2">Daftar Mata Kuliah</h2>

        <div class="overflow-x-auto rounded-box border bg-base-100">
            <table class="table w-full">
                <thead class="bg-blue-500 text-white">
                    <tr>
                        <th>No</th>
                        <th>Kode MK</th>
                        <th>Nama MK</th>
                        <th>SKS</th>
                        <th>Hari</th>
                        <th>Jam</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($mahasiswa->registrasi as $i => $reg)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $reg->penawaran->kodemk }}</td>
                            <td>{{ $reg->penawaran->mk->nama ?? '-' }}</td>
                            <td>{{ $reg->sks }}</td>
                            <td>{{ $reg->hari }}</td>
                            <td>
                                {{ $reg->mulaipukul }} - {{ $reg->selesaipukul }}
                            </td>
                            <td>{{ $reg->status }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                Belum ada mata kuliah terdaftar
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            <a href="{{url()->previous()}}"
               class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md shadow">
                ← Kembali
            </a>
        </div>
    </div>
</x-layout>