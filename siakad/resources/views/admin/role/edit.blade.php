<x-layout>
      <a class="join-item btn btn-primary" href="{{url()->previous()}}">⮜ Previous page</a>
    <form class="flex"action="{{route('roles.update', $role->id)}}" method="POST">
    @csrf
    @method('PATCH')
    <fieldset class="fieldset bg-base-200 border-base-300 w-auto field-sizing-content rounded-box border p-4 mx-auto">

    

        <label class="label font-bold" for="name">Name</label>
        <input type="text" class="input w-auto" name="name" placeholder="" value="{{$role->name}}"/>
        <x-forms.error name='name'/>
            <div id="permissions-wrapper">
                <label class="label font-bold mt-4">Permissions yang dimiliki role ini</label>
                <div class="grid grid-cols-2 gap-3 p-2 bg-base-100 rounded-box border">
                    @foreach($permissions as $permission)
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input
                                type="checkbox"
                                name="permissions[]"
                                value="{{ $permission->name }}"
                                class="checkbox checkbox-primary permission-checkbox"
                                {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}/>
                            <span class="label-text">{{ $permission->name }}</span>
                        </label>
                    @endforeach
                </div>
                <x-forms.error name='permissions'/>
            </div>


        <button class="btn btn-primary mt-4">Edit Role</button>
  </fieldset>

  </form>
</x-layout>