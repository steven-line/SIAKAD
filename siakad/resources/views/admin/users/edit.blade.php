<x-layout>
    {{-- BACK BUTTON (dynamic previous URL) --}}
    <a class="join-item btn btn-primary mb-4" href="{{ url()->previous() }}">
        ⮜ Previous page
    </a>

    {{-- UPDATE FORM (no hardcode) --}}
    <form action="{{ route('users.update', $user) }}" method="POST">
        @csrf
        @method('PATCH')

        <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-full max-w-md border p-6 mx-auto">
            <legend class="fieldset-legend font-bold text-lg">
                Edit Akun: {{ $user->username }}
            </legend>

            {{-- Username --}}
            <label class="label font-bold" for="username">Username</label>
            <input type="text"
                   class="input w-full"
                   name="username"
                   value="{{ $user->username }}"
                   required />
            <x-forms.error name='username'/>

            {{-- Password (disabled) --}}
            <label class="label font-bold" for="password">Password</label>
            <input type="password"
                   class="input w-full bg-base-300"
                   placeholder="Password tidak bisa diubah di sini"
                   disabled />

            @php
                $userRole = $user->roles->first()->name ?? '';
            @endphp

            {{-- ROLE --}}
            <label class="label font-bold mt-4" for="role-select">
                Pilih Role Utama
            </label>

            <select id="role-select"
                    name="role"
                    class="select select-bordered w-full"
                    required>

                <option disabled {{ empty($userRole) ? 'selected' : '' }}>
                    Pilih satu role...
                </option>

                @foreach($roles as $role)
                    <option value="{{ $role->name }}"
                        {{ $userRole === $role->name ? 'selected' : '' }}>
                        {{ ucfirst($role->name) }}
                    </option>
                @endforeach
            </select>

            <x-forms.error name='role'/>

            {{-- PERMISSIONS --}}
            <div id="permissions-wrapper"
                 style="{{ strtolower($userRole) === 'admin' ? 'display:none;' : '' }}">

                <label class="label font-bold mt-4">
                    Akses Tambahan (Permissions)
                </label>

                <div class="grid grid-cols-2 gap-3 p-2 bg-base-100 rounded-box border">

                    @foreach($permissions as $permission)
                        <label class="flex items-center gap-2 cursor-pointer">

                            <input type="checkbox"
                                   name="permissions[]"
                                   value="{{ $permission->name }}"
                                   class="checkbox checkbox-primary permission-checkbox"
                                   {{ $user->hasPermissionTo($permission->name) ? 'checked' : '' }} />

                            <span class="label-text">
                                {{ $permission->name }}
                            </span>

                        </label>
                    @endforeach

                </div>

                <x-forms.error name='permissions'/>
            </div>

            {{-- SKS --}}
            <label class="label font-bold mt-4" for="sks">SKS</label>
            <input type="number"
                   class="input w-full"
                   name="sks"
                   value="{{ $user->sks }}"
                   required />

            <x-forms.error name='sks'/>

            <button class="btn btn-primary mt-6 w-full">
                Simpan Perubahan
            </button>
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
                checkboxes.forEach(cb => cb.checked = false);
            } else {
                permWrapper.style.display = 'block';

                const allowed = rolesData[selectedRole] || [];

                checkboxes.forEach(cb => {
                    cb.checked = allowed.includes(cb.value);
                });
            }
        });
    </script>
</x-layout>