<x-layout>
    @php
        $user = auth()->user();
    @endphp

    <div class="max-w-6xl mx-auto p-6">

        {{-- Header --}}
        <div class="hero rounded-2xl bg-gradient-to-r from-blue-700 via-blue-600 to-sky-500 text-white shadow-xl mb-8">
            <div class="hero-content w-full py-10">
                <div>
                    <h1 class="text-4xl font-bold">
                        Dashboard
                    </h1>

                    <p class="mt-2 opacity-90">
                        Selamat datang kembali,
                        <span class="font-bold">{{ $user->username }}</span>
                    </p>
                </div>
            </div>
        </div>

        {{-- Informasi --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            {{-- Username --}}
            <div class="card bg-base-100 shadow-lg border-t-4 border-blue-600 hover:shadow-xl transition">
                <div class="card-body">
                    <div class="text-4xl">👤</div>

                    <h2 class="card-title text-sm text-gray-500">
                        Username
                    </h2>

                    <p class="text-2xl font-bold text-blue-700">
                        {{ $user->username }}
                    </p>
                </div>
            </div>

            {{-- Role --}}
            <div class="card bg-base-100 shadow-lg border-t-4 border-sky-500 hover:shadow-xl transition">
                <div class="card-body">
                    <div class="text-4xl">🛡️</div>

                    <h2 class="card-title text-sm text-gray-500">
                        Role
                    </h2>

                    <div class="flex flex-wrap gap-2 mt-2">
                        @forelse($user->getRoleNames() as $role)
                            <span class="badge badge-info badge-lg">
                                {{ ucfirst($role) }}
                            </span>
                        @empty
                            <span class="text-gray-400">
                                Tidak memiliki role
                            </span>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Status --}}
            <div class="card bg-base-100 shadow-lg border-t-4 border-indigo-600 hover:shadow-xl transition">
                <div class="card-body">
                    <div class="text-4xl">
                        {{ $user->aktif ? '✅' : '⛔' }}
                    </div>

                    <h2 class="card-title text-sm text-gray-500">
                        Status Akun
                    </h2>

                    @if($user->aktif)
                        <span class="badge badge-success badge-lg w-fit">
                            Aktif
                        </span>

                        <p class="text-gray-600 mt-2">
                            Akun dapat digunakan untuk mengakses seluruh fitur sistem.
                        </p>
                    @else
                        <span class="badge badge-error badge-lg w-fit">
                            Tidak Aktif
                        </span>

                        <p class="text-gray-600 mt-2">
                            Akun dinonaktifkan sehingga akses ke sistem dibatasi.
                        </p>
                    @endif
                </div>
            </div>

        </div>

    </div>
</x-layout>