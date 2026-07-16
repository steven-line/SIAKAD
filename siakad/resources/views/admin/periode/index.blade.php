<x-layout title="index">
<div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100">

    <a class="btn btn-primary text-white mb-6"
       href="{{ route('periode.create') }}">
        Create Periode
    </a>

    <table class="table">
        <thead class="bg-blue-500 text-white">
        <tr>
            <th>No</th>
            <th>Id</th>
            <th>Tahun Ajaran</th>
            <th>Tanggal Mulai</th>
            <th>Tanggal Selesai</th>
            <th>Created At</th>
            <th>Updated At</th>
            <th>Semester</th>
            <th colspan="3">Aksi</th>
        </tr>
        </thead>

        <tbody>
        @forelse($periodes as $periode)
            <tr>
                <th>{{ $loop->index }}</th>
                <th>{{ $periode->id }}</th>
                <th>{{ $periode->tahun_ajaran }}</th>
                <th>{{ $periode->tanggal_mulai }}</th>
                <th>{{ $periode->tanggal_selesai }}</th>
                <th>{{ $periode->created_at }}</th>
                <th>{{ $periode->updated_at }}</th>
            @php
                $isGanjilActive = $periode->semesters->where('jenis', 'Ganjil')->where('aktif', true)->count() > 0;
                $isGenapActive  = $periode->semesters->where('jenis', 'Genap')->where('aktif', true)->count() > 0;
            @endphp

            <th>
                {{-- GANJIL --}}
                <form action="{{ route('periode.aktifkan', [$periode->id, 'Ganjil']) }}"
                    method="POST"
                    style="display:inline-block;">
                    @csrf
                    <button type="submit"
                        class="btn {{ $isGanjilActive ? 'btn-success text-white' : 'btn-soft btn-info' }}">
                        Ganjil
                    </button>
                </form>

                {{-- GENAP --}}
                <form action="{{ route('periode.aktifkan', [$periode->id, 'Genap']) }}"
                    method="POST"
                    style="display:inline-block;">
                    @csrf
                    <button type="submit"
                        class="btn {{ $isGenapActive ? 'btn-success text-white' : 'btn-soft btn-info' }}">
                        Genap
                    </button>
                </form>
            </th>
                            {{-- DETAIL --}}
                <th>
                    <a href="{{ route('periode.show', $periode->id) }}"
                       class="btn btn-soft btn-primary">
                        Detail
                    </a>
                </th>

                {{-- EDIT --}}
                <th>
                    <form action="{{ route('periode.periodeAktif', $periode->id) }}" method="POST">
                            @csrf

                            <button type="submit"
                                class="btn 
                                {{ $periode->aktif ? 'btn-success text-white cursor-not-allowed' : 'btn-soft btn-info' }}"
                                {{ $periode->aktif ? 'disabled' : '' }}>
                                
                                {{ $periode->aktif ? 'Aktif' : 'Aktifkan' }}
                                
                            </button>
                        </form>
                     
                </th>
                  

                {{-- DELETE BUTTON --}}
                <th>
                    <button class="btn btn-soft btn-error"
                            onclick="deleteBox_{{ $periode->id }}.showModal()">
                        Delete
                    </button>

                    <dialog id="deleteBox_{{ $periode->id }}"
                            class="modal modal-bottom sm:modal-middle">
                        <div class="modal-box">
                            <h3 class="text-lg font-bold">Peringatan Penghapusan</h3>
                            <p class="py-4">Apa anda yakin ingin menghapus?</p>

                            <div class="modal-action">
                                <form method="dialog">
                                    <button class="btn btn-neutral">Tidak</button>
                                </form>

                                <form method="POST"
                                    action="{{ route('periode.destroy', $periode->id) }}">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-primary">
                                        Ya
                                    </button>
                                </form>
                            </div>
                        </div>
                    </dialog>
                </th>
            </tr>

            <form id="delete-periode-form-{{ $periode->id }}"
                  action="{{ route('periode.destroy', $periode->id) }}"
                  method="POST">
                @csrf
                @method('DELETE')
            </form>
         @empty
            <tr>
                <td colspan="5" class="text-center">Tidak ada data</td>
            </tr>

        @endforelse
        <td>{{$periodes->links()}}</td>
        </tbody>
    </table>

</div>
</x-layout>