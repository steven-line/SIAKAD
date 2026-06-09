<x-layout>
    <a class="join-item btn btn-primary mb-4" href="/admin/kelola-user">⮜ Previous page</a>

    <form action="/admin/kelola-user" method="POST">
        @csrf
        <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-sm border p-6 mx-auto">
            <legend class="fieldset-legend font-bold text-lg">Tambah User Baru</legend>

            <label class="label font-bold" for="username">Username</label>
            <input type="number" class="input w-full" name="username" placeholder="Username/NRP" required />
            <x-forms.error name='username'/>

            <label class="label font-bold" for="password">Password</label>
            <input type="password" class="input w-full" name="password" placeholder="Password" required />
            <x-forms.error name='password'/>

            <label class="label font-bold mt-4" for="role-select">Pilih Role Utama</label>
            <select id="role-select" name="role" class="select select-bordered w-full" required>
                <option disabled selected>Pilih satu role...</option>
                @foreach($roles as $role)
                    <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                @endforeach
            </select>
            <x-forms.error name='role'/>

            <div id="permissions-wrapper" style="display: none;">
                <label class="label font-bold mt-4">Akses Tambahan (Permissions)</label>
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

            <label class="label font-bold mt-4" for="sks">SKS</label>
            <input type="number" class="input w-full" name="sks" placeholder="Contoh: 20" required />
            <x-forms.error name='sks'/>

            <button class="btn btn-primary mt-6 w-full">Buat Akun</button>
        </fieldset>
    </form>

    <script>
    const rolesData = @json(
        $roles->keyBy('name')->map(function($role) {
            return $role->permissions->pluck('name');
        })
    );

    const roleSelect = document.getElementById('role-select');
    const permWrapper = document.getElementById('permissions-wrapper');
    const checkboxes = document.querySelectorAll('.permission-checkbox');

    roleSelect.addEventListener('change', function () {

        const selectedRole = this.value;

        if (selectedRole.toLowerCase() === 'admin') {
            permWrapper.style.display = 'none';

            checkboxes.forEach(cb => {
                cb.checked = false;
                cb.classList.remove('default-role-permission');
            });

            return;
        }

        permWrapper.style.display = 'block';

        const allowed = rolesData[selectedRole] || [];

        checkboxes.forEach(cb => {

            cb.classList.remove('default-role-permission');

            if (allowed.includes(cb.value)) {

                cb.checked = true;
                cb.classList.add('default-role-permission');

            } else {

                cb.checked = false;
            }
        });
    });

    // cegah permission bawaan role diubah
    document.querySelectorAll('.permission-checkbox').forEach(cb => {

        cb.addEventListener('click', function(e) {

            if (this.classList.contains('default-role-permission')) {

                e.preventDefault();
                this.checked = true;

            }

        });

    });
</script>
</x-layout>