<x-layout>
<div class="flex justify-center items-center ">
    <div class="card bg-base-200 border border-base-300 shadow-xl  w-8/10 mx-auto p-8">
    <h1  class="font-bold text-2xl ">Detail Prodi</h1>
    <div class="card-body">
        <div class="grid grid-rows-2 gap-2">
            <div class="grid grid-cols-2 gap-2">
                <div>
                    <p class="font-semibold text-base-content/70">Kode Prodi</p>
                    <p class="text-lg"> {{$prodi->kode_prodi}}</p>
                </div>
                  <div>
                    <p class="font-semibold text-base-content/70">Nama Prodi</p>
                    <p class="text-lg"> {{$prodi->nama_prodi}}</p>
                </div>
                
                <div>
                    <p class="font-semibold text-base-content/70">Kode Jurusan</p>
                    <p class="text-lg"> {{$prodi->kode_jurusan}}</p>
                </div>
                <div>
                    <p class="font-semibold text-base-content/70">Kode Prodi Dikti</p>
                    <p class="text-lg"> {{$prodi->kode_prodi_dikti}}</p>
                </div>
             </div>
    
        <div class="mt-5">
            <a class="btn btn-primary" href="{{route('prodi.index')}}">Kembali</a>
            <a class="btn btn-warning" href="{{route('prodi.edit', $prodi)}}">Edit</a>
       </div> 
     
        </div>
     
      
        
        </div>
    </div>
    </div>
</div>

</x-layout>