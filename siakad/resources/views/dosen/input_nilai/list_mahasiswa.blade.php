
<x-layout title="Daftar Mahasiswa">

<a class="join-item btn btn-primary mb-10" href="{{ url()->previous() }}">
    ⮜ Previous page
</a>
    @if(session('error'))
        <div class="alert alert-error mb-5 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
          
                <div>{{ session(error) }}</div>
            
        </div>
    @endif
<div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100">

    <table class="table">

        <thead class="bg-blue-500 text-white">
            <tr>
                <th>No</th>
                <th>NRP</th>
                <th>Nama Mahasiswa</th>
                <th>Kode MK</th>
                <th>Nama Mata Kuliah</th>
                <th>Semester</th>

                <th>SKS</th>
                <th colspan="3">Aksi</th>
            </tr>
        </thead>

        <tbody>

            @forelse($mahasiswas as $reg)

            @php
                $mhs = $reg->mahasiswa;
                $krs = $reg->krs;

                $nrp = $mhs?->nrp;
                $nama = $mhs?->biodata?->nama;

                $semester = $reg->penawaran?->semester?->periode?->tahun_ajaran;
                $jenis = $reg->penawaran?->semester?->jenis;
            @endphp

            <tr>
                <td>{{ $loop->iteration }}</td>

                <td>{{ $nrp ?? '-' }}</td>
                <td>{{ $nama ?? '-' }}</td>

                <td>{{ $mk->kodemk }}</td>
                <td>{{ $mk->nama }}</td>

                <td>{{ $semester ?? '-' }} - {{ $jenis ?? '-' }}</td>

          
                <td>{{ $krs->sks ?? $mk->sks }}</td>

                {{-- SHOW --}}
                <td>
                    <a class="btn btn-soft btn-warning"
                    href="{{ route('nilai.show', [
                            'mahasiswa' => $nrp,
                            'mk' => $mk->kodemk
                    ]) }}">
                        Show
                    </a>
                </td>
                @if(now()->gte($periodeInputNilai->input_nilai_mulai) && now()->lte($periodeInputNilai->input_nilai_selesai))
                {{-- EDIT (kalau sudah ada nilai) --}}
                    <td>
                        
                            <a class="btn btn-soft btn-error"
                            href="{{ route('nilai.edit', [
                                    'mahasiswa' => $nrp,
                                    'mk' => $mk->kodemk
                            ]) }}">
                                Edit
                            </a>
                
                    </td>
                @endif
            

            </tr>

            @empty
            <tr>
                <td colspan="10" class="text-center">
                    Tidak ada mahasiswa
                </td>
            </tr>
            @endforelse

        </tbody>

    </table>

</div>

</x-layout>