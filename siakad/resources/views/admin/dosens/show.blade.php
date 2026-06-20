<x-layout>
<div class="flex justify-center items-center ">
    <div class="card bg-base-200 border border-base-300 shadow-xl  w-8/10 mx-auto p-8">
    <h1  class="font-bold text-2xl ">Detail dosen</h1>
    <div class="card-body">
        <div class="grid grid-rows-2 gap-2">
            <div class="grid grid-cols-2 gap-2">
                <div>
                    <p class="font-semibold text-base-content/70">Nim Dosen</p>
                    <p class="text-lg"> {{$dosen->nim_dosen}}</p>
                </div>
                  <div>
                    <p class="font-semibold text-base-content/70">Nip Dosen</p>
                    <p class="text-lg"> {{$dosen->nip}}</p>
                </div>
                <div>
                    <p class="font-semibold text-base-content/70">Nama</p>
                    <p class="text-lg"> {{$dosen->nama}}</p>
                </div>
                <div>
                    <p class="font-semibold text-base-content/70">User</p>
                    <p class="text-lg"> {{$dosen->user->username}}</p>
                </div>
                 <div>
                    <p class="font-semibold text-base-content/70">Prodi</p>
                    <p class="text-lg"> {{$dosen->prodi}}</p>
                </div>
                 <div>
                    <p class="font-semibold text-base-content/70">Jabatan Struktural</p>
                    <p class="text-lg"> {{$dosen->jabatan_struktural}}</p>
                </div>
             </div>
    
        <div class="mt-5">
            <a class="btn btn-primary" href="{{route('dosen.index')}}">Kembali</a>
            <a class="btn btn-warning" href="{{route('dosen.edit', $dosen)}}">Edit</a>
       </div> 
     
        </div>
     
      
        
        </div>
    </div>
    </div>
</div>

</x-layout>