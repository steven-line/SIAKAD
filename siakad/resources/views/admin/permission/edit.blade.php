<x-layout>
      <a class="join-item btn btn-primary" href="{{url()->previous()}}">⮜ Previous page</a>
    <form class="flex"action="{{route('permissions.update',$permission->id)}}" method="POST">
    @csrf
    @method('PATCH')

    <fieldset class="fieldset bg-base-200 border-base-300 field-sizing-content rounded-box w-xs border p-4 mx-auto">

    

        <label class="label font-bold" for="name">Name</label>
        <input type="text" class="input" name="name" placeholder="" value="{{$permission->name}}"/>
        <x-forms.error name='name'/>

        <button class="btn btn-primary mt-4">Ubah Permission</button>
  </fieldset>

  </form>
</x-layout>