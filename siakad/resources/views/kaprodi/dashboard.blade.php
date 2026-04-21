<x-layout>
<<<<<<< HEAD
        <h1 class="text-2xl font-bold mb-6">Dashboard Kaprodi</h1>

    <!-- Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        
        <div class="bg-white shadow rounded-xl p-5">
            <h2 class="text-gray-500 text-sm">Total Mahasiswa</h2>
            <p class="text-2xl font-bold mt-2">120</p>
=======
<div class="flex flex-col h-full justify-between bg-gray-900 p-4">

    <!-- ATAS -->
    <div>
        <div class="mb-6 text-white font-bold text-lg">
            Kaprodi Menu
>>>>>>> 5801e2cf1bb2996a8542a69e2cce7114f9236356
        </div>

        <ul class="space-y-3">

            <li>
                <a href="/kaprodi/kelola_jadwal/"
                   class="block bg-blue-600 hover:bg-blue-700 text-white p-3 rounded-lg transition">
                    📄 Kelola Jadwal
                </a>
            </li>

            <li>
                <a href="/kaprodi/approval"
                   class="block bg-green-600 hover:bg-green-700 text-white p-3 rounded-lg transition">
                    ✅ Approval KRS
                </a>
            </li>

            <li>
                <a href="#"
                   class="block bg-yellow-500 hover:bg-yellow-600 text-black font-medium p-3 rounded-lg transition">
                    📊 Monitoring KRS
                </a>
            </li>

            <li>
                <a href="#"
                   class="block bg-red-600 hover:bg-red-700 text-white p-3 rounded-lg transition">
                    ⚙️ Pengaturan
                </a>
            </li>

        </ul>
    </div>

    <!-- BAWAH -->
    <div>
        <form method="POST" action="/logout">
            @csrf
            @method('DELETE')
            <button class="w-full bg-gray-700 hover:bg-gray-800 text-white p-3 rounded-lg transition">
                Logout
            </button>
        </form>
    </div>

</div>
<<<<<<< HEAD

</x-layout>
    <!-- Title -->
=======
</x-layout>     
>>>>>>> 5801e2cf1bb2996a8542a69e2cce7114f9236356
