<x-layout title="Daftar Mahasiswa Anak Wali">


    <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100">

        <table class="table">

            <thead class="bg-blue-500 text-white">
                <tr>
                    <th>No</th>
                    <th>NRP</th>
                    <th>Nama Mahasiswa</th>
                    <th>Program Studi</th>
                    <th>Dosen Wali</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

                @forelse($mahasiswas as $mhs)

                    <tr>

                        <td>{{ $loop->iteration }}</td>

                        <td>{{ $mhs->nrp }}</td>

                        <td>{{ $mhs->biodata->nama ?? '-'}}</td>

                        <td>{{ $mhs->prodi }}</td>

                        <td>{{ $mhs->dosen_wali }}</td>

                        <td>

                            <a
                                class="btn btn-soft btn-info"
                                href="{{route('nilai_krs_anak_wali.show', $mhs->nrp)}}">

                                Lihat Nilai

                            </a>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="6" class="text-center">
                            Tidak ada mahasiswa anak wali.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    <div class="mt-5">
        {{ $mahasiswas->links() }}
    </div>

</x-layout>