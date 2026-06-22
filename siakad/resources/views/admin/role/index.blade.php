<x-layout title="index">
 <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100">
    <a class="btn btn-primary text-white mb-6" href="{{route('roles.create')}}">Create Role</a>
  <table class="table">
    <thead class="bg-blue-500 text-white">
      <tr>
        <th>No</th>
        <th>id</th>
        <th>name</th>
        <th>guard_name</th>      
        <th>permissions</th> 
        <th>created_at</th>
        <th>updated_at</th>
        <th colspan="3">Aksi</th>
      </tr>
    </thead>
    <tbody>
      <!-- row 1 -->
       @foreach($roles as $role)
        <tr>
            <th>{{$loop->index}}</th>
           
            <th>{{$role->id}}</th>
            <th>{{$role->name}}</th>
            <th>{{$role->guard_name}}</th>
            <th>
            @foreach ($role->permissions as $permission)
               <div>{{$permission->name}}</div> 
            @endforeach
            </th>
   
            <th>{{$role->created_at}}</th>
            <th>{{$role->updated_at}}</th>
           
            <th><a href='{{ route('roles.show', $role)}}' class="btn btn-soft btn-primary">Detail</a></th>
            <th><a class="btn btn-soft btn-warning" href="{{route('roles.edit', $role->id)}}">Edit</a></th>
            <th>
              <button class="btn btn-soft btn-error" onclick="deleteBox_{{$role->id}}.showModal()">Delete</button>
              <dialog id="deleteBox_{{$role->id}}" class="modal modal-bottom sm:modal-middle">
                <div class="modal-box">
                  <h3 class="text-lg font-bold">Peringatan Penghapusan</h3>
                  <p class="py-4">Apa anda yakin ingin menghapus?</p>
                  <div class="modal-action">
                    <form method="dialog">
                      <!-- if there is a button in form, it will close the modal -->
                      <button class="btn btn-primary" form="delete-role-form-{{$role->id}}">Ya</button>
                      <button class="btn btn-neutral">Tidak</button>
                    </form>
                  </div>
                </div>
              </dialog>
            </th>
        </tr>
        
        <form id="delete-role-form-{{$role->id}}" action="{{route('roles.destroy', $role->id)}}" method='POST'>
            @csrf  
            @method('DELETE')
       </form>
      @endforeach
      <td>
{{ $roles->links() }}</td>
    </tbody>
  </table>
  <!-- Open the modal using ID.showModal() method -->
 

</div>
</x-layout>