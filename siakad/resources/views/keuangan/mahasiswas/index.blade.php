<x-layout title="index">
<div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100">
@if(session('error'))
    <div class="alert alert-error mb-4">
        <span>{{ session('error') }}</span>
    </div>
@endif

@if(session('success'))
    <div class="alert alert-success mb-4">
        <span>{{ session('success') }}</span>
    </div>
@endif
<div class="flex gap-2 mb-6">

    <form action="{{ route('keuangan.mahasiswa.index') }}" method="GET" class="flex gap-2">

        <input
            type="text"
            name="search"
            value="{{ $search ?? '' }}"
            placeholder="Cari NRP..."
            class="input input-bordered w-64"
        >

        <button type="submit" class="btn btn-primary">
            Search
        </button>

        @if(!empty($search))
            <a
                href="{{ route('keuangan.mahasiswa.index') }}"
                class="btn btn-neutral"
            >
                Reset
            </a>
        @endif

    </form>

<form
    action="{{ route('keuangan.mahasiswa.upload') }}"
    method="POST"
    enctype="multipart/form-data"
    class="mb-6"
>
    @csrf

    <div class="flex gap-2 items-center">

        <input
            type="file"
            name="file"
            accept=".csv,.xlsx,.xls"
            class="file-input file-input-bordered"
            required
        >

        <button type="submit" class="btn btn-primary">
            Upload
        </button>

    </div>

    <x-forms.error name="file"/>
</form>
<a href="{{ route('keuangan.mahasiswa.export') }}" class="btn btn-success mb-5">
    Download Template
</a>
</div>
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
            <th>{{$mahasiswa->dosenWali->nim_dosen .' - '. $mahasiswa->dosenWali->nama}}</th>
            <th>{{$mahasiswa->status_blokir}}</th>
            <th>{{$mahasiswa->programStudi->kode_prodi . ' - ' . $mahasiswa->programStudi->nama_prodi}}</th>
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