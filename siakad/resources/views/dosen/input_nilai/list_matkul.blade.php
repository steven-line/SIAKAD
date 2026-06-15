<x-layout title="Daftar Mata Kuliah">

<div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100">

    <table class="table">

        <thead class="bg-blue-500 text-white">
            <tr>
                <th>No</th>
                <th>Kode MK</th>
                <th>Nama Mata Kuliah</th>

                <th>Periode</th>
                <th>Sesi</th>
                <th>Hari</th>
                <th>Jam</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>

            @forelse($mks as $mk)

            <tr>
                <td>{{ $loop->iteration }}</td>

                <td>{{ $mk->kodemk }}</td>

                <td>
                    {{ $mk->mk->nama ?? '-' }}
                </td>

     

                <td>{{ $mk->periode }}</td>

                <td>{{ $mk->sesi }}</td>

                <td>{{ $mk->hari }}</td>

                <td>
                    {{ substr($mk->mulaipukul,0,5) }}
                    -
                    {{ substr($mk->selesaipukul,0,5) }}
                </td>

                <td>
                    <a
                        class="btn btn-soft btn-info"
                        href="/dosen/input-nilai/{{ $mk->kodemk }}/mahasiswa">
                        Lihat Mahasiswa
                    </a>
                </td>

            </tr>

            @empty

            <tr>
                <td colspan="9" class="text-center">
                    Tidak ada mata kuliah yang diajar
                </td>
            </tr>

            @endforelse

        </tbody>

    </table>

</div>

<div class="mt-4">
    {{ $mks->links() }}
</div>

</x-layout>