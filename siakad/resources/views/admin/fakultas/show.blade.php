<x-layout>
<div class="flex justify-center items-center ">
    <div class="card bg-base-200 border border-base-300 shadow-xl  w-8/10 mx-auto p-8">
    <h1  class="font-bold text-2xl ">Detail Fakultas</h1>
    <div class="card-body">
        <div class="grid grid-rows-2 gap-2">
            <div class="grid grid-cols-2 gap-2">
                <div>
                    <p class="font-semibold text-base-content/70">Kode Fakultas</p>
                    <p class="text-lg"> {{$fakultas->kode_fakultas}}</p>
                </div>
                  <div>
                    <p class="font-semibold text-base-content/70">Nama Fakultas</p>
                    <p class="text-lg"> {{$fakultas->nama_fakultas}}</p>
                </div>
             
             </div>
    
        <div class="mt-5">
            <a class="btn btn-primary" href="{{route('fakultas.index')}}">Kembali</a>
            <a class="btn btn-warning" href="{{route('fakultas.edit', $fakultas->id)}}">Edit</a>
       </div> 
     
        </div>
     
      
        
        </div>
    </div>
    </div>
</div>

</x-layout>