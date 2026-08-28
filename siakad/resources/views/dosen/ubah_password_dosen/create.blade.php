<x-layout>

    <div class="mb-4">
        <a
            class="btn btn-primary"
            href="/"
        >
            ⮜ Previous page
        </a>
    </div>

    {{-- Pesan berhasil --}}
    @if(session('success'))
        <div class="alert alert-success mb-4">
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <form action="{{ route('dosen.password.create') }}" method="POST">
        @csrf

        <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-xs border p-6 mx-auto">

            <legend class="fieldset-legend font-bold text-lg">
                Ubah Password
            </legend>

            {{-- PASSWORD LAMA --}}
            <label
                class="label font-bold"
                for="password_lama"
            >
                Password Lama
            </label>

            <input
                type="password"
                class="input w-full"
                name="password_lama"
                id="password_lama"
                placeholder="Masukkan password lama"
                required
            />

            <x-forms.error name="password_lama"/>


            {{-- PASSWORD BARU --}}
            <label
                class="label font-bold mt-4"
                for="password_baru"
            >
                Password Baru
            </label>

            <input
                type="password"
                class="input w-full"
                name="password_baru"
                id="password_baru"
                placeholder="Masukkan password baru"
                required
            />

            <x-forms.error name="password_baru"/>


            {{-- KONFIRMASI PASSWORD --}}
            <label
                class="label font-bold mt-4"
                for="password_baru_confirmation"
            >
                Konfirmasi Password Baru
            </label>

            <input
                type="password"
                class="input w-full"
                name="password_baru_confirmation"
                id="password_baru_confirmation"
                placeholder="Ulangi password baru"
                required
            />

            <x-forms.error name="password_baru_confirmation"/>


            <button
                type="submit"
                class="btn btn-primary mt-6 w-full"
            >
                Ubah Password
            </button>

        </fieldset>
    </form>

</x-layout>