<x-layout>
<a class="btn btn-primary text-white mb-6"
   href="{{ route('users.create') }}">
    Create User
</a>

<table class="table table-fixed w-full text-sm">
    <thead class="bg-blue-500 text-white">
        <tr>
            <th class="w-12">No</th>
            <th>Username</th>
            <th>Role</th>
            <th class="w-24">Pataum</th>
            <th class="w-20">Aktif</th>
            <th class="text-center w-60">Aksi</th>
        </tr>
    </thead>

    <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{ $loop->iteration }}</td>

                <td>{{ $user->username }}</td>

                {{-- ROLE --}}
                <td>
                    @foreach($user->getRoleNames() as $role)
                        <span class="badge badge-primary badge-sm">
                            {{ $role }}
                        </span>
                    @endforeach
                </td>

                <td>{{ $user->pataum }}</td>
                <td>{{ $user->aktif }}</td>

                <td class="flex gap-2 justify-center">

                    {{-- DETAIL --}}
                    <a href="{{ route('users.show', $user)}}"
                       class="btn btn-soft btn-primary btn-sm">
                        Detail
                    </a>

                    {{-- EDIT --}}
                    <a class="btn btn-soft btn-warning btn-sm"
                       href="{{ route('users.edit', $user) }}">
                        Edit
                    </a>

                    {{-- DELETE BUTTON --}}
                    <button class="btn btn-soft btn-error btn-sm"
                        onclick="document.getElementById('deleteBox_{{ $user->username }}').showModal()">
                        Delete
                    </button>

                    {{-- MODAL --}}
                    <dialog id="deleteBox_{{ $user->username }}"
                            class="modal modal-bottom sm:modal-middle">

                        <div class="modal-box">
                            <h3 class="text-lg font-bold">
                                Peringatan Penghapusan
                            </h3>

                            <p class="py-4">
                                Apa anda yakin ingin menghapus user
                                <strong>{{ $user->username }}</strong>?
                            </p>

                            <div class="modal-action">

                                <form method="dialog">
                                    <button class="btn">Tidak</button>
                                </form>

                                <form action="{{ route('users.destroy', $user) }}"
                                      method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-error" type="submit">
                                        Ya, Hapus
                                    </button>
                                </form>

                            </div>
                        </div>

                    </dialog>

                </td>
            </tr>
        @endforeach
    </tbody>
</table>

{{-- PAGINATION --}}
<div class="mt-4">
    {{ $users->links() }}
</div>
</x-layout>