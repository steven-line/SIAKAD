<x-layout>
    <div>Nama: </div>
    <div>NIM KRS ONLINE: </div>

 <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100">
  <table class="table">
    <!-- head -->
    <thead class="bg-blue-500 text-white">
      <tr>
        <th>No</th>
        <th>NRP</th>
        <th>Nama</th>
        <th>Dosen Wali</th>
        <th>Status (non-Blokiran)</th>
        <th colspan="3">Act</th>
      </tr>
    </thead>
    <tbody>
      <!-- row 1 -->
       @forelse($mahasiswas as $mahasiswa)
        <tr>
            <th>{{$loop->index}}</th>
            <th>{{$mahasiswa->nrp}}</th>
            <th>{{$mahasiswa->nama}}</th>
            <th>{{$mahasiswa->dosenWali->nama}}</th>
            <th>{{$mahasiswa->status_blokir}}</th>
            <th><button class="btn btn-neutral">TN</button></th>
            <th><button class="btn btn-warning">RL</button></th>
            <th><button class="btn btn-error">LC</button></th>
        </tr>

       @empty
       <tr>
            <th colspan="6" class="text-center">Tidak ada anak wali</th>
       </tr>
      @endforelse
    </tbody>
  </table>


</div>
</x-layout>
