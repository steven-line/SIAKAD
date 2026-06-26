<x-layout>
<div class="flex justify-center items-center ">
    <div class="card bg-base-200 border border-base-300 shadow-xl  w-8/10 mx-auto p-8">
    <h1  class="font-bold text-2xl ">Detail Permission</h1>
    <div class="card-body">
        <div class="grid grid-rows-2 gap-2">
            <div class="grid grid-cols-2 gap-2">
                <div>
                    <p class="font-semibold text-base-content/70">Id </p>
                    <p class="text-lg"> {{$permission->id}}</p>
                </div>
                  <div>
                    <p class="font-semibold text-base-content/70">Name</p>
                    <p class="text-lg"> {{$permission->name}}</p>
                </div>
                 <div>
                    <p class="font-semibold text-base-content/70">Guard Name</p>
                    <p class="text-lg"> {{$permission->guard_name}}</p>
                </div>
                 <div>
                    <p class="font-semibold text-base-content/70">Created At</p>
                    <p class="text-lg"> {{$permission->created_at}}</p>
                </div>
                 <div>
                    <p class="font-semibold text-base-content/70">Updated At</p>
                    <p class="text-lg"> {{$permission->updated_at}}</p>
                </div>
             </div>
    
        <div class="mt-5">
            <a class="btn btn-primary" href="{{route('permissions.index')}}">Kembali</a>
       </div> 
     
        </div>
     
      
        
        </div>
    </div>
    </div>
</div>

</x-layout>