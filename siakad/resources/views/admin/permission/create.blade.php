<x-layout>
      <a class="join-item btn btn-primary" href="{{route('permissions.index')}}">⮜ Previous page</a>
    <form class="flex"action="{{route('permissions.store')}}" method="POST">
    @csrf

    <fieldset class="fieldset bg-base-200 border-base-300 field-sizing-content rounded-box w-xs border p-4 mx-auto">

    

        <label class="label font-bold" for="name">Name</label>
        <input type="text" class="input" maxlength="191" value="{{old('name')}}" name="name" placeholder="" />
        <x-forms.error name='name'/>

        <button class="btn btn-primary mt-4">Buat Permission</button>
  </fieldset>

  </form>
</x-layout>