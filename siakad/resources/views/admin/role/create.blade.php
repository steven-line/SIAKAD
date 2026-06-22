<x-layout>
      <a class="join-item btn btn-primary" href="{{route('roles.index')}}">⮜ Previous page</a>
    <form class="flex mt-10" action="{{route('roles.store')}}" method="POST">
    @csrf
    
    <fieldset class="fieldset bg-base-200 border-base-300 w-8/10 field-sizing-content rounded-box border p-4 mx-auto">

    

        <label class="label font-bold" for="name">Name</label>
        <input type="text" class="input w-auto" maxlength="191" value="{{old('name')}}"name="name" placeholder="" />
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
/>
                            <span class="label-text">{{ $permission->name }}</span>
                        </label>
                    @endforeach
                </div>
                <x-forms.error name='permissions'/>
            </div>


        <button class="btn btn-primary mt-4">Buat Role</button>
  </fieldset>

  </form>
</x-layout>