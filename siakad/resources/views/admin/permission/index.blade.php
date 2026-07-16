<x-layout title="Daftar Permission">

<div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100">

    <a class="btn btn-primary text-white mb-6" href="{{ route('permissions.create') }}">
        Create Permission
    </a>
    <table class="table">

        <thead class="bg-blue-500 text-white">
            <tr>
                <th>No</th>
                <th>ID</th>
                <th>Permission</th>
                <th>Guard</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>

            @foreach($permissions as $permission)

            <tr>
                <td>{{ $loop->iteration + ($permissions->currentPage()-1) * $permissions->perPage() }}</td>

                <td>{{ $permission->id }}</td>

                <td>{{ $permission->name }}</td>

                <td>{{ $permission->guard_name }}</td>

                <td>
                    <a href="{{ route('permissions.show', $permission) }}"
                       class="btn btn-soft btn-primary btn-sm">
                        Detail
                    </a>
                </td>
            </tr>

            @endforeach

        </tbody>

    </table>

    <div class="p-4">
        {{ $permissions->links() }}
    </div>

</div>

</x-layout>