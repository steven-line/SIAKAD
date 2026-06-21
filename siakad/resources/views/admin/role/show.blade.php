<x-layout>
<div class="flex justify-center items-center ">
    <div class="card bg-base-200 border border-base-300 shadow-xl  w-8/10 mx-auto p-8">
    <h1  class="font-bold text-2xl ">Detail Role</h1>
    <div class="card-body">
        <div class="grid grid-rows-2 gap-2">
            <div class="grid grid-cols-2 gap-2">
                <div>
                    <p class="font-semibold text-base-content/70">Name</p>
                    <p class="text-lg"> {{$role->name}}</p>
                </div>
                <div>
                    <p class="font-semibold text-base-content/70">Guard Name</p>
                    <p class="text-lg"> {{$role->guard_name}}</p>
                </div>
                <div>
                    <p class="font-semibold text-base-content/70">Created At</p>
                    <p class="text-lg"> {{$role->created_at}}</p>
                </div>
                <div>
                    <p class="font-semibold text-base-content/70">Updaated At</p>
                    <p class="text-lg"> {{$role->updated_at}}</p>
                </div>
             </div>
            <div >
                <div class="font-semibold text-base-content/70">
                    <p>Permissions</p>
                </div>
                <div class="bg-white grid grid-cols-2 p-5 gap-2">
                     @foreach ($permissions as $permission)
                        <span class="badge badge-soft badge-primary" >{{$permission}}</span>
                    @endforeach
                </div>
            
             
        </div>
        <div class="mt-5">
            <a class="btn btn-primary" href="{{route('roles.index')}}">Kembali</a>
            <a class="btn btn-warning" href="{{route('roles.edit', $role)}}">Edit</a>
       </div> 
     
        </div>
     
      
        
        </div>
    </div>
    </div>
</div>

</x-layout>