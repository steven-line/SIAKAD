<x-layout title="index">
    <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100 p-4">
        <a class="btn btn-primary text-white mb-6" href="/admin/kelola-user/create">Create User</a>
        
        <table class="table w-full">
            <thead class="bg-blue-500 text-white">
                <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Role</th> 
                    <th>Permissions (Individu)</th> <th>SKS</th>
                    <th>First Login</th>
                    <th>Last Login</th>
                    <th>Validasi</th>
                    <th>Akses Nilai</th>
                    <th>Pataum</th>
                    <th>Aktif</th>
                    <th>Prodi</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <th>{{ $loop->iteration }}</th> 
                        <td>{{ $user->username }}</td>
                        
                        <td>
                            @foreach($user->getRoleNames() as $role)
                                <span class="badge badge-primary badge-sm">{{ $role }}</span>
                            @endforeach
                        </td>

                        <td>
                            @foreach($user->getDirectPermissions() as $permission)
                                <span class="badge badge-outline badge-sm">{{ $permission->name }}</span>
                            @endforeach
                        </td>

                        <td>{{ $user->sks }}</td>
                        <td>{{ $user->firstlogin }}</td>
                        <td>{{ $user->lastlogin }}</td>
                        <td>{{ $user->validasi }}</td>
                        <td>{{ $user->aksesnilai }}</td>
                        <td>{{ $user->pataum }}</td>
                        <td>{{ $user->aktif }}</td>
                        <td>{{ $user->prodi }}</td>
                        
                        <td class="flex gap-2">
                            <a href="#" class="btn btn-soft btn-primary btn-sm">Detail</a>
                            <a class="btn btn-soft btn-warning btn-sm" href="/admin/kelola-user/{{$user->username}}/edit">Edit</a>
                            
                            <button class="btn btn-soft btn-error btn-sm" onclick="deleteBox_{{$user->username}}.showModal()">Delete</button>
                            
                            <dialog id="deleteBox_{{$user->username}}" class="modal modal-bottom sm:modal-middle">
                                <div class="modal-box">
                                    <h3 class="text-lg font-bold">Peringatan Penghapusan</h3>
                                    <p class="py-4">Apa anda yakin ingin menghapus user <strong>{{ $user->username }}</strong>?</p>
                                    <div class="modal-action">
                                        <form method="dialog">
                                            <button class="btn">Tidak</button>
                                        </form>
                                        <form action="/admin/kelola-user/{{ $user->username }}" method='POST'>
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-error" type="submit">Ya, Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </dialog>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-layout>