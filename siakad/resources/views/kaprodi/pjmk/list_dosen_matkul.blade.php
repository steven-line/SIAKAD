<x-layout title="index">
<div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100">


    <table class="table">
        <thead class="bg-blue-500 text-white">
        <tr>
            <th>No</th>
            <th>Nim Dosen</th>
            <th>Nama Dosen</th>
            <th>Pataum</th>
            <th colspan="3">Aksi</th>
        </tr>
        </thead>

        <tbody>
        @forelse($dosens as $dosen)
            <tr>
                <th>{{ $loop->index + 1 }}</th>
                <td>{{$dosen->nim_dosen}}</td>
                <td>{{$dosen->nama}}</td>
                <td>{{$dosen->user->pataum}}</td>
                <td>
                  
                    <form action="{{route('pjmk.setPjmk')}}" method="POST">
                    @csrf 
                    @method('PATCH')
                    <input type="hidden">
                    <input type="hidden" name="nim_dosen" value="{{ $dosen->nim_dosen }}">
                    <input type="hidden" name="kodemk" value="{{ $mk->kodemk }}">
                    <input type="hidden" name="periode_id" value="{{ $periode->id }}">
                    <input type="hidden" name="jenis" value="{{$semester->jenis}}">
                    <input type="text" name="" id="">
                      @if($dosen?->nim_dosen == $currentPjmk?->nim_dosen)
                        <button class="btn btn-soft btn-success">PJMK</button>
                      @else
                         <button class="btn btn-soft">PJMK</button>
                      @endif
                </form>
                
                </td>
                
              

            </tr>
        @empty
            <tr>
                <td colspan="9" class="text-center">Tidak ada data</td>
            </tr>
        @endforelse

        <tr>
            <td colspan="9">
                {{ $dosens->links() }}
            </td>
        </tr>
      
        </tbody>
    </table>

</div>
</x-layout>