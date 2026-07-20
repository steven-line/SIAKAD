<x-layout title="index">
<div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100">


    <table class="table">
        <thead class="bg-blue-500 text-white">
        <tr>
            <th>No</th>
            <th>Kode MK</th>
            <th>Nama MK</th>
            <th colspan="3">Aksi</th>
        </tr>
        </thead>

        <tbody>
        @forelse($penawarans as $penawaran)
            <tr>
                <th>{{ $loop->index + 1 }}</th>
                <td>{{$penawaran->kodemk}}</td>
                <td>{{$penawaran->mk->nama}}</td>
                <td>
                    <a href="{{ route('pjmk.list_dosen_matkul', $penawaran->kodemk) }}"
                       class="btn btn-soft btn-primary">
                        Dosen MK
                    </a>
                </td>
                

              

            </tr>
        @empty
            <tr>
                <td colspan="9" class="text-center">Tidak ada data</td>
            </tr>
        @endforelse

        <tr>
            <td colspan="9">
                {{ $penawarans->links() }}
            </td>
        </tr>
        </tbody>
    </table>

</div>
</x-layout>