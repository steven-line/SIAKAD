<x-layout>
<div class="min-h-screen bg-gray-900 p-6 text-white">

    <!-- HEADER -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold">
            Selamat datang Kaprodi {{ auth()->user()->prodi }}
        </h1>
        <p class="text-gray-400 mt-1">
            Sistem Informasi Akademik - Dashboard Kaprodi
        </p>
    </div>

        <!-- INFO USER -->
        <div class="bg-gray-800 p-6 rounded-lg shadow">
            <h2 class="font-semibold mb-4 text-lg">Informasi Akun</h2>

            <div class="space-y-2 text-gray-300">
                <p><strong>Username:</strong> {{ auth()->user()->username }}</p>
                <p><strong>Prodi:</strong> {{ auth()->user()->prodi }}</p>
                <p><strong>Level:</strong> Kaprodi</p>
            </div>
        </div>

    </div>

    <!-- LOGOUT -->
    <div class="mt-8">
        <form method="POST" action="/logout">
            @csrf
            @method('DELETE')

            <button class="w-full bg-gray-700 hover:bg-gray-800 p-3 rounded-lg transition">
                Logout
            </button>
        </form>
    </div>

</div>
</x-layout>