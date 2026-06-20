<x-layout>
<div class="flex justify-center items-center ">
    <div class="card bg-base-200 border border-base-300 shadow-xl  w-8/10 mx-auto p-8">
    <h1  class="font-bold text-2xl ">Detail User</h1>
    <div class="card-body">
        <div class="grid grid-rows-2 gap-2">
            <div class="grid grid-cols-2 gap-2">
                <div>
                    <p class="font-semibold text-base-content/70">Username</p>
                    <p class="text-lg"> {{$user->username}}</p>
                </div>
                <div>
                    <p class="font-semibold text-base-content/70">Role</p>
                    <p class="text-lg"> {{$user->getRoleNames()->first()}}</p>
                </div>
                <div>
                    <p class="font-semibold text-base-content/70">Sks</p>
                    <p class="text-lg"> {{$user->sks}}</p>
                </div>
             </div>
            <div >
                <div class="font-semibold text-base-content/70">
                    Permissions:
                </div>
                <div class="bg-white grid grid-cols-2 p-5 gap-2">
                     @foreach ($user->getAllPermissions()->pluck('name') as $permission)
                        <span class="badge badge-soft badge-primary" >{{$permission}}</span>
                    @endforeach
                </div>
            
             
        </div>
        <div class="mt-5">
            <a class="btn btn-primary" href="{{route('users.index')}}">Kembali</a>
            <a class="btn btn-warning" href="{{route('users.edit', $user)}}">Edit</a>
       </div> 
     
        </div>
     
      
        
        </div>
    </div>
    </div>
</div>

</x-layout>