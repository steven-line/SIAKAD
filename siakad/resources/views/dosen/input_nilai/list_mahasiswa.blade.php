<x-layout title="Daftar Mahasiswa">
 <a class="join-item btn btn-primary mb-10"  href="{{url()->previous()}}">⮜ Previous page</a>
<div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100">

    <table class="table">

        <thead class="bg-blue-500 text-white">
            <tr>
                <th>No</th>
                <th>NRP</th>
                <th>Nama Mahasiswa</th>
                <th>Kode MK</th>
                <th>Nama Mata Kuliah</th>
                <th>Periode</th>
                <th>Status</th>
                <th>SKS</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>

            @forelse($mahasiswas as $mhs)

            <tr>
                <td>{{ $loop->iteration }}</td>

                <td>{{ $mhs->nrp }}</td>

                <td>
                    {{ $mhs->mahasiswa->nama ?? '-' }}
                </td>

                <td>{{ $mhs->kodemk }}</td>

                <td>
                    {{ $mhs->matkul->nama ?? '-' }}
                </td>

                <td>{{ $mhs->periode }}</td>

                <td>{{ $mhs->status }}</td>

                <td>{{ $mhs->sks }}</td>
                <td>
                   <a class="btn btn-soft btn-warning"
   href="/dosen/input-nilai/{{ $mhs->nrp }}/{{ $mk->kodemk }}">
   Show
</a>

                </td>
                <td>
                    <a
                        class="btn btn-soft btn-info"
                        href="/dosen/input-nilai/{{$mhs->nrp}}/{{$mk->kodemk}}/create">
                        Input Nilai
                    </a>
                </td>

            </tr>

            @empty

            <tr>
                <td colspan="9" class="text-center">
                    Belum ada mahasiswa yang mengambil mata kuliah ini
                </td>
            </tr>

            @endforelse

        </tbody>

    </table>

</div>


</x-layout>