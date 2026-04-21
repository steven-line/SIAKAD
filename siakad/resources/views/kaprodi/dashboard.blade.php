<x-layout>
        <h1 class="text-2xl font-bold mb-6">Dashboard Kaprodi</h1>

    <!-- Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        
        <div class="bg-white shadow rounded-xl p-5">
            <h2 class="text-gray-500 text-sm">Total Mahasiswa</h2>
            <p class="text-2xl font-bold mt-2">120</p>
        </div>

        <div class="bg-white shadow rounded-xl p-5">
            <h2 class="text-gray-500 text-sm">KRS Disetujui</h2>
            <p class="text-2xl font-bold mt-2">95</p>
        </div>

        <div class="bg-white shadow rounded-xl p-5">
            <h2 class="text-gray-500 text-sm">KRS Pending</h2>
            <p class="text-2xl font-bold mt-2">25</p>
        </div>

    </div>

    <!-- Menu Aksi -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        <!-- 🔥 SUDAH TERHUBUNG -->
        <a href="/kaprodi/matakuliah" class="bg-blue-500 text-white p-5 rounded-xl shadow hover:bg-blue-600 transition block">
            📄 Kelola Mata Kuliah
        </a>

        <a href="/kaprodi/approval" class="bg-green-500 text-white p-5 rounded-xl shadow hover:bg-green-600 transition block">
            ✅ Approval KRS
        </a>

        <a href="#" class="bg-yellow-500 text-white p-5 rounded-xl shadow hover:bg-yellow-600 transition block">
            📊 Monitoring KRS
        </a>

        <a href="#" class="bg-red-500 text-white p-5 rounded-xl shadow hover:bg-red-600 transition block">
            ⚙️ Pengaturan
        </a>

    </div>

</div>

</x-layout>
    <!-- Title -->
