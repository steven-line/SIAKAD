<x-layout title="index">
 <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100">

    <table class="table">
    <thead class="bg-blue-500 text-white">
      <tr>
        <th>No</th>
        <th>Nrp</th>
        <th>Dosen Wali</th>
        <th>Status Blokir</th>
        <th>Prodi</th>       
        <th colspan="3">Aksi</th>
      </tr>
    </thead>
    <tbody>
      <!-- row 1 -->
       @foreach($mahasiswas as $mahasiswa)
        <tr>
            <th>{{$loop->index}}</th>
           
            <th>{{$mahasiswa->nrp}}</th>
            <th>{{$mahasiswa->dosen_wali}}</th>
            <th>{{$mahasiswa->status_blokir}}</th>
            <th>{{$mahasiswa->prodi}}</th>
            <th><a href='{{route('keuangan.mahasiswa.show', $mahasiswa->nrp)}}' class="btn btn-soft btn-primary">Detail</a></th>
            <th>
              @if($mahasiswa->status_blokir == 'BLOKIR')
                <form action="{{route('keuangan.mahasiswa.bukablokir', $mahasiswa->nrp)}}" method="POST">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-soft btn-success">Buka Blokir</button>
                </form>
              @else
                <form action="{{route('keuangan.mahasiswa.blokir', $mahasiswa->nrp)}}" method="POST">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-soft btn-error">Blokir</button>
                </form>
              @endif
            </th>
        </tr>
        
      @endforeach
      <td>
      {{ $mahasiswas->links() }}</td>
    </tbody>
  </table>
  <!-- Open the modal using ID.showModal() method -->
 

</div>
</x-layout>