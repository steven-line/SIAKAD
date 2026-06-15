<x-layout title="index">
 <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100">
    <a class="btn btn-primary text-white mb-6" href="/admin/master-permission/create">Create Permission</a>
  <table class="table">
    <thead class="bg-blue-500 text-white">
      <tr>
        <th>No</th>
        <th>Id</th>
        <th>Name</th>
        <th>Guard_name</th>       
        <th colspan="3">Aksi</th>
      </tr>
    </thead>
    <tbody>
      <!-- row 1 -->
       @foreach($permissions as $permission)
        <tr>
            <th>{{$loop->index}}</th>
           
            <th>{{$permission->id}}</th>
            <th>{{$permission->name}}</th>
            <th>{{$permission->guard_name}}</th>
            <th><a href='' class="btn btn-soft btn-primary">Detail</a></th>
            <th><a class="btn btn-soft btn-warning" href="/admin/master-permission/{{$permission->id}}/edit">Edit</a></th>
            <th>
              <button class="btn btn-soft btn-error" onclick="deleteBox_{{$permission->id}}.showModal()">Delete</button>
              <dialog id="deleteBox_{{$permission->id}}" class="modal modal-bottom sm:modal-middle">
                <div class="modal-box">
                  <h3 class="text-lg font-bold">Peringatan Penghapusan</h3>
                  <p class="py-4">Apa anda yakin ingin menghapus?</p>
                  <div class="modal-action">
                    <form method="dialog">
                      <!-- if there is a button in form, it will close the modal -->
                      <button class="btn btn-primary" form="delete-permission-form-{{$permission->id}}">Ya</button>
                      <button class="btn btn-neutral">Tidak</button>
                    </form>
                  </div>
                </div>
              </dialog>
            </th>
        </tr>
        
        <form id="delete-permission-form-{{$permission->id}}" action="/admin/master-permission/{{ $permission->id }}" method='POST'>
            @csrf  
            @method('DELETE')
       </form>
      @endforeach
      <td>
{{ $permissions->links() }}</td>
    </tbody>
  </table>
  <!-- Open the modal using ID.showModal() method -->
 

</div>
</x-layout>