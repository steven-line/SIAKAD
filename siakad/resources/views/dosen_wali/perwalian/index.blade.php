<x-layout title="index">
 <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100">
  <table class="table">
    <!-- head -->
    <thead class="bg-blue-500 text-white">
      <tr>
        <th>No</th>
        <th>NRP</th>
        <th>Nama</th>
        <th>Dosen Wali</th>
        <th>Status</th>
        <th colspan="3">Aksi</th>
      </tr>
    </thead>
    <tbody>
      <!-- row 1 -->
       @forelse($mahasiswas as $mahasiswa)
        <tr>
            <td>{{$loop->index}}</td>
            <td>{{$mahasiswa->nrp}}</td>
            <td>{{$mahasiswa->biodata->nama ?? '-'}}</td>
            <td>{{$mahasiswa->dosen_wali}}</td>
            <td>
              {{ $mahasiswa->status_blokir }}
          </td>
            <td><a class="btn btn-soft btn-info" href="{{route('perwalian.show',$mahasiswa->nrp)}}">Detail</a></td>
            <td>
          @if ($mahasiswa->status_blokir === 'MENUNGGU_VALIDASI')
              <button class="btn btn-soft btn-warning"
                      form="validasi-mahasiswa-form-{{$mahasiswa->nrp}}">
                  Validasi
              </button>
          @endif
          </td>

          <td>
        
              <button class="btn btn-soft btn-warning"
                      form="lock-mahasiswa-form-{{$mahasiswa->nrp}}">
                  Lock
              </button>
        
          </td>


           
        </tr>
             


       </form>
       <form id="validasi-mahasiswa-form-{{$mahasiswa->nrp}}" action="{{ route('perwalian.validasi', $mahasiswa->nrp) }}" method='POST'>
            @csrf  
       </form>
      <form id="lock-mahasiswa-form-{{$mahasiswa->nrp}}" action="{{ route('perwalian.lock', $mahasiswa->nrp) }}" method='POST'>
            @csrf        
       </form>
        
      @empty
      <tr>
        <td colspan="5" class="text-center">Tidak ada data</td>
      </tr>
      @endforelse
    </tbody>
  </table>
  <!-- Open the modal using ID.showModal() method -->
 

</div>
</x-layout>