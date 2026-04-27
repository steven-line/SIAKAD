<x-layout>
<div class="flex flex-col h-full justify-between bg-gray-900 p-4">

    <!-- ATAS -->
    <div>
        <div class="mb-6 text-white font-bold text-lg">
            Kaprodi Menu
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

</x-layout>
    <!-- Title -->
