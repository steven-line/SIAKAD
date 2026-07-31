<x-layout title="SKS Mahasiswa">

<div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100">

    <div class="p-4">
        <h1 class="text-2xl font-bold">
            SKS Mahasiswa
        </h1>

        <p class="text-sm text-gray-500 mt-1">
            Kelola toleransi SKS mahasiswa.
        </p>
    </div>

    <form action="{{ route('ips.generate') }}" method="POST" class="mb-4">
        @csrf

        <button class="btn btn-success">
            Generate IPS Semua Mahasiswa
        </button>
    </form>

    @if(session('success'))
        <div class="alert alert-success mx-4 mb-4">
            {{ session('success') }}
        </div>
    @endif

    <table class="table">

        <thead class="bg-blue-500 text-white">
            <tr>
                <th>No</th>
                <th>NRP</th>
                <th>Nama Mahasiswa</th>
                <th>IPS</th>
                <th>Maksimal SKS</th>
                <th>Toleransi</th>
                <th width="120">Aksi</th>
            </tr>
        </thead>

        <tbody>

        @forelse($mahasiswas as $mahasiswa)

            <tr>

                <td>
                    {{ $loop->iteration }}
                </td>

                <td>
                    {{ $mahasiswa->nrp }}
                </td>

                <td>
                    {{ $mahasiswa->biodata->nama ?? '-' }}
                </td>

                <td>
                    {{ number_format($mahasiswa->ips->ips ?? 0, 3) }}
                </td>

                <td>
                    {{ $mahasiswa->ips->maksimal_sks ?? 0 }}
                </td>

                <td>
                    {{ $mahasiswa->ips->toleransi ?? 0 }}
                </td>

                <td>

                    @if($mahasiswa->ips)

                        <a
                            href="{{ route('ips.show', $mahasiswa->ips->nrp) }}"
                            class="btn btn-warning btn-sm text-white">

                            Kelola

                        </a>

                    @else

                        <span class="badge badge-error">
                            Belum Ada Data
                        </span>

                    @endif

                </td>

            </tr>

        @empty

            <tr>
                <td colspan="7" class="text-center py-6">
                    Tidak ada data mahasiswa.
                </td>
            </tr>

        @endforelse

        </tbody>

    </table>

</div>

</x-layout>