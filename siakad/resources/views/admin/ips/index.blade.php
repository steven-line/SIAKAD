<x-layout title="SKS Mahasiswa">

@php
    $meta = \App\Models\Metaperiode::first();

    $ipsSudahDibuka =
        $meta &&
        $meta->pengumuman_nilai_final_selesai &&
        now()->gt($meta->pengumuman_nilai_final_selesai);
@endphp

<div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100">

    <div class="p-4">

        <h1 class="text-2xl font-bold">
            SKS Mahasiswa
        </h1>

        <p class="text-sm text-gray-500 mt-1">
            Kelola toleransi SKS mahasiswa.
        </p>

    </div>

    @if(session('success'))
        <div class="alert alert-success mx-4 mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- STATUS PERIODE --}}
    @if(!$ipsSudahDibuka)

        <div class="alert alert-warning mx-4 mb-4">

            <div>

                <div class="font-bold">
                    IPS Belum Tersedia
                </div>

                <div class="text-sm mt-1">
                    IPS mahasiswa akan muncul otomatis setelah
                    <b>Periode Pengumuman Nilai Final</b> berakhir.
                </div>

                @if($meta && $meta->pengumuman_nilai_final_selesai)

                    <div class="mt-2">

                        Pengumuman berakhir pada:

                        <b>
                            {{ $meta->pengumuman_nilai_final_selesai->format('d F Y H:i') }}
                        </b>

                    </div>

                @endif

            </div>

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

            <td>{{ $loop->iteration }}</td>

            <td>{{ $mahasiswa->nrp }}</td>

            <td>{{ $mahasiswa->biodata->nama ?? '-' }}</td>

            {{-- IPS --}}
            <td>
                @if($ipsSudahDibuka && $mahasiswa->ips)
                    {{ number_format($mahasiswa->ips->ips, 3) }}
                @else
                    -
                @endif
            </td>

            {{-- Maksimal SKS --}}
            <td>
                @if($mahasiswa->ips)
                    {{ $mahasiswa->ips->maksimal_sks }}
                @else
                    19
                @endif
            </td>

            {{-- Toleransi --}}
            <td>
                @if($mahasiswa->ips)
                    {{ $mahasiswa->ips->toleransi }}
                @else
                    0
                @endif
            </td>

            <td>

                @if($ipsSudahDibuka)

                    @if($mahasiswa->ips)

                        <a href="{{ route('ips.show', $mahasiswa->ips->nrp) }}"
                        class="btn btn-warning btn-sm text-white">
                            Kelola
                        </a>

                    @else

                        <span class="badge badge-neutral">
                            Belum Ada Data
                        </span>

                    @endif

                @else

                    <span class="badge badge-warning">
                        Menunggu
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