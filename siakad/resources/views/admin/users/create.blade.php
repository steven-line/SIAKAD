
<x-layout>
    <a class="join-item btn btn-primary mb-4" href="{{ route('users.index') }}">
        ⮜ Previous page
    </a>

    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-sm border p-6 mx-auto">
            <legend class="fieldset-legend font-bold text-lg">Tambah User Baru</legend>

            <!-- Username -->
            <label class="label font-bold" for="username">Username</label>
            <input type="number" class="input w-full" maxlength="15" value="{{ old('username') }}" name="username" placeholder="Username/NRP" required />
            <x-forms.error name='username'/>

            <!-- Password -->
            <label class="label font-bold" for="password">Password</label>
            <input type="password" class="input w-full" maxlength="255" value="{{ old('password') }}" name="password" placeholder="Password" required />
            <x-forms.error name='password'/>

            <!-- Role -->
            <label class="label font-bold mt-4" for="role-select">Pilih Role Utama</label>
            <select id="role-select" name="role" class="select select-bordered w-full" required>
                <option disabled selected>Pilih satu role...</option>
                @foreach($roles as $role)
                    <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                @endforeach
            </select>
            <x-forms.error name='role'/>

            <!-- Permissions (tampil jika role bukan admin) -->
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

            <!-- SKS -->
            <label class="label font-bold mt-4" for="sks">SKS</label>
            <input type="number" class="input w-full" oninput="this.value=this.value.slice(0,this.maxLength)" maxlength="10" value="{{ old('sks') }}" name="sks" placeholder="Contoh: 20" required />
            <x-forms.error name='sks'/>

            <!-- PATAUM (khusus mahasiswa) -->
            <div id="pataum-wrapper" style="display: none;">
                <label class="label font-bold mt-4">Pilih Jadwal (Pagi/Malam)</label>
                <div class="flex gap-4 mt-1">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="pataum" value="P" class="radio radio-primary" />
                        <span>Pagi</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="pataum" value="M" class="radio radio-primary" />
                        <span>Malam</span>
                    </label>
                </div>
                <x-forms.error name='pataum'/>
            </div>

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
        const pataumWrapper = document.getElementById('pataum-wrapper');
        const checkboxes = document.querySelectorAll('.permission-checkbox');

        roleSelect.addEventListener('change', function () {
            const selectedRole = this.value.toLowerCase();

            // Atur tampilan permissions
            if (selectedRole === 'admin') {
                permWrapper.style.display = 'none';
                checkboxes.forEach(cb => {
                    cb.checked = false;
                    cb.classList.remove('default-role-permission');
                });
            } else {
                permWrapper.style.display = 'block';
                const allowed = rolesData[this.value] || [];
                checkboxes.forEach(cb => {
                    cb.classList.remove('default-role-permission');
                    if (allowed.includes(cb.value)) {
                        cb.checked = true;
                        cb.classList.add('default-role-permission');
                    } else {
                        cb.checked = false;
                    }
                });
            }

            // Atur tampilan pataum (hanya untuk mahasiswa)
            if (selectedRole === 'mahasiswa') {
                pataumWrapper.style.display = 'block';
            } else {
                pataumWrapper.style.display = 'none';
                // Reset radio button jika disembunyikan
                document.querySelectorAll('input[name="pataum"]').forEach(el => el.checked = false);
            }
        });

        // Cegah permission bawaan role diubah
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