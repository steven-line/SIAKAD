<x-layout>
    {{-- BACK BUTTON --}}
    <a class="join-item btn btn-primary mb-4" href="{{ route('users.index') }}">
        ⮜ Previous page
    </a>

    {{-- UPDATE FORM --}}
    <form action="{{ route('users.update', $user) }}" method="POST">
        @csrf
        @method('PATCH')

        <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-full max-w-md border p-6 mx-auto">
            <legend class="fieldset-legend font-bold text-lg">
                Edit Akun: {{ $user->username }}
            </legend>

            {{-- Username --}}
            <label class="label font-bold" for="username">Username</label>
            <input
                type="text"
                class="input w-full"
                name="username"
                maxlength="15"
                value="{{ $user->username }}"
                required
            />
            <x-forms.error name="username"/>

            {{-- Password --}}
            <label class="label font-bold" for="password">Password</label>
            <input
                type="password"
                class="input w-full bg-base-300"
                placeholder="Password tidak bisa diubah di sini"
                disabled
            />

            @php
                $userRole = $user->roles->first()->name ?? '';

                $rolePermissions = collect();

                if ($userRole) {
                    $rolePermissions = $roles
                        ->firstWhere('name', $userRole)
                        ?->permissions
                        ->pluck('name') ?? collect();
                }
            @endphp

            {{-- ROLE --}}
            <label class="label font-bold mt-4" for="role-select">
                Pilih Role Utama
            </label>

            <select
                id="role-select"
                name="role"
                class="select select-bordered w-full"
                required
            >
                <option disabled {{ empty($userRole) ? 'selected' : '' }}>
                    Pilih satu role...
                </option>

                @foreach($roles as $role)
                    <option
                        value="{{ $role->name }}"
                        {{ $userRole === $role->name ? 'selected' : '' }}
                    >
                        {{ ucfirst($role->name) }}
                    </option>
                @endforeach
            </select>

            <x-forms.error name="role"/>

            {{-- PERMISSIONS --}}
            <div
                id="permissions-wrapper"
                style="{{ strtolower($userRole) === 'admin' ? 'display:none;' : '' }}"
            >
                <label class="label font-bold mt-4">
                    Akses Tambahan (Permissions)
                </label>

                <div class="grid grid-cols-2 gap-3 p-2 bg-base-100 rounded-box border">
                    @foreach($permissions as $permission)
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input
                                type="checkbox"
                                name="permissions[]"
                                value="{{ $permission->name }}"
                                class="checkbox checkbox-primary permission-checkbox
                                    {{ $rolePermissions->contains($permission->name) ? 'default-role-permission' : '' }}"
                                {{ $user->hasPermissionTo($permission->name) ? 'checked' : '' }}
                            />

                            <span class="label-text">
                                {{ $permission->name }}
                            </span>
                        </label>
                    @endforeach
                </div>

                <x-forms.error name="permissions"/>
            </div>

            {{-- SKS --}}
            <label class="label font-bold mt-4" for="sks">SKS</label>
            <input
                type="number"
                class="input w-full"
                name="sks"
                maxlength="10"
                oninput="this.value=this.value.slice(0,this.maxLength)"
                value="{{ $user->sks }}"
                required
            />

            <x-forms.error name="sks"/>

            {{-- STATUS AKTIF --}}
            <label class="label font-bold mt-4">Status Akun</label>
            <div class="flex gap-4 mt-1">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio" name="aktif" value="1" class="radio radio-primary"
                        {{ $user->aktif == 1 ? 'checked' : '' }} />
                    <span>Aktif</span>
                </label>

                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio" name="aktif" value="0" class="radio radio-primary"
                        {{ $user->aktif == 0 ? 'checked' : '' }} />
                    <span>Tidak Aktif</span>
                </label>
            </div>
            <x-forms.error name="aktif"/>

            <button class="btn btn-primary mt-6 w-full">
                Simpan Perubahan
            </button>
        </fieldset>
    </form>

    <script>
        const rolesData = @json(
            $roles->keyBy('name')->map(function ($role) {
                return $role->permissions->pluck('name');
            })
        );

        const roleSelect = document.getElementById('role-select');
        const permWrapper = document.getElementById('permissions-wrapper');
        const checkboxes = document.querySelectorAll('.permission-checkbox');

        function applyRolePermissions(roleName) {
            const selectedRole = roleName.toLowerCase();
            const allowed = rolesData[roleName] || [];

            // reset semua checkbox dulu
            checkboxes.forEach(cb => {
                cb.checked = false;
                cb.classList.remove('default-role-permission');
            });

            // kalau admin, cukup sembunyikan permission
            if (selectedRole === 'admin') {
                permWrapper.style.display = 'none';
                return;
            }

            permWrapper.style.display = 'block';

            // centang sesuai permission role yang dipilih
            checkboxes.forEach(cb => {
                if (allowed.includes(cb.value)) {
                    cb.checked = true;
                    cb.classList.add('default-role-permission');
                }
            });
        }

        roleSelect.addEventListener('change', function () {
            applyRolePermissions(this.value);
        });

        // inisialisasi saat halaman dibuka
   

        // cegah permission bawaan role di-uncheck manual
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