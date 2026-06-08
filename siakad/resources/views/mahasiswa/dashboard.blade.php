<x-layout title="Dashboard Mahasiswa">
    <div class="px-4 py-6 max-w-7xl mx-auto">
        <!-- Sapaan -->
        <div class="mb-8">
            <h1 class="text-2xl md:text-3xl font-semibold text-gray-800">Hello Mahasiswa</h1>
            <p class="text-gray-500 text-sm mt-1">Selamat datang kembali. Berikut ringkasan akademik Anda.</p>
        </div>

        <!-- 4 Kartu Statistik: IPS, IPK, SKS, SKK -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
            <!-- Kartu IPS -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 transition hover:shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">IPS</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $ips ?? '3.45' }}</p>
                    </div>
                    <div class="bg-blue-50 p-3 rounded-full">
                        <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Kartu IPK -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 transition hover:shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">IPK</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $ipk ?? '3.52' }}</p>
                    </div>
                    <div class="bg-green-50 p-3 rounded-full">
                        <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Kartu SKS -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 transition hover:shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">SKS</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $sks ?? '108' }}</p>
                    </div>
                    <div class="bg-purple-50 p-3 rounded-full">
                        <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Kartu SKK -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 transition hover:shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">SKK</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $skk ?? '42' }}</p>
                    </div>
                    <div class="bg-yellow-50 p-3 rounded-full">
                        <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Masa Studi -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center space-x-3">
                <div class="bg-indigo-50 p-2 rounded-full">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Masa Studi</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $masaStudi ?? 'Semester 6 (Tahun ke-3)' }}</p>
                </div>
            </div>
        </div>
    </div>
</x-layout>