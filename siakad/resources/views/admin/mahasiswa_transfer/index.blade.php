<x-layout title="index">
 <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100">


@if (session('error'))
    <div class="alert alert-error">
        {{ session('error') }}
    </div>
@endif
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
<form action="{{route('mahasiswa_transfer.index')}}" method="GET" class="mb-5">
        <input type="text" name="search" value='{{$search ?? ''}}' class="file-input px-2" placeholder="Cari Mahasiswa...">
        <button type="submit" class="btn btn-primary">Cari</button>
         @if(!empty($search))
            <a
                href="{{ route('mahasiswa_transfer.index') }}"
                class="btn btn-neutral"
            >
                Reset
            </a>
        @endif
    </form>
<form action="{{route('mahasiswa_transfer.upload')}}" class="mb-10" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <input type="file" name="file"  accept=".csv, .xlsx, .xls" class="file-input">
          <input type="submit" value="Upload File" class="btn btn-primary">
      </form>
       <a href=" {{ route('mahasiswa_transfer.export')}}"  class="btn btn-success mb-5">Download Template</a>
    <table class="table table-fixed w-full">
    <thead class="bg-blue-500 text-white">
      <tr>
        <th class="w-12">No</th>
        <th>Nrp</th>
        <th>Nama</th>
        <th>Dosen Wali</th>
        <th>Status Blokir</th>
        <th>Prodi</th>       
        <th>Aksi</th>
   
      </tr>
    </thead>
    <tbody>
      <!-- row 1 -->
       @foreach($mahasiswas as $mahasiswa)
        <tr>
            <td class="w-12">{{$loop->index}}</td>
            <td>{{$mahasiswa->nrp}}</td>
            <td>{{$mahasiswa->biodata->nama ?? '-'}}</td>
            <td>{{$mahasiswa->dosenWali->nim_dosen .' - '. $mahasiswa->dosenWali->nama}}</td>
            <td>{{$mahasiswa->status_blokir}}</td>
            <td>{{$mahasiswa->programStudi->kode_prodi . ' - ' . $mahasiswa->programStudi->nama_prodi}}</td>
            <td>
                <a href="{{route('mahasiswa_transfer.show', $mahasiswa->nrp)}}" class="btn btn-active btn-primary">Detail</a>
            </td>
        </tr>
        
   
      @endforeach
      <tr>   <td>
      {{ $mahasiswas->links() }}</td></tr>
   
    </tbody>
  </table>
  <!-- Open the modal using ID.showModal() method -->
 

</div>
</x-layout>