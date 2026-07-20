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
                    @if($isPjmk->contains($dosen->nim_dosen))
                        <button type="submit" form="setPjmk-form-{{$dosen->nim_dosen}}" class="btn btn-soft btn-success">
                    
                        pjmk</button>
                    @else 
                        <button type="submit" form="setPjmk-form-{{$dosen->nim_dosen}}" class="btn btn-soft btn-warning">
                    
                        pjmk</button>
                    @endif</td>  
            
                <form id="setPjmk-form-{{$dosen->nim_dosen}}" action="{{route('pjmk.setPjmk', ['mk' => $mk->kodemk, 'dosen' => $dosen->nim_dosen])}}" method="post">
                    @csrf
                    @method('PATCH')
                </form>

              

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