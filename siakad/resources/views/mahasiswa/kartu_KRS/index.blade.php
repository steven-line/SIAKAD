<x-layout title="KRS Mahasiswa">
    @php
        // Data dummy mata kuliah (KRS)
        $krsItems = [
            (object) [
                'kode' => 'KM5001',
                'nama_mk' => 'KULIAH KERJA NYATA',
                'status' => 'BARU',
                'hari' => 'Sabtu',
                'jam_mulai' => '10:30:01',
                'jam_selesai' => '13:00:00',
                'sks' => 3,
            ],
            (object) [
                'kode' => 'TF9705',
                'nama_mk' => 'PROPOSAL TUGAS AKHIR',
                'status' => 'BARU',
                'hari' => 'Sabtu',
                'jam_mulai' => '18:00:01',
                'jam_selesai' => '18:50:00',
                'sks' => 4,
            ],
            (object) [
                'kode' => 'TF9708',
                'nama_mk' => 'MAGANG',
                'status' => 'BARU',
                'hari' => 'Sabtu',
                'jam_mulai' => '19:40:01',
                'jam_selesai' => '21:20:00',
                'sks' => 4,
            ],
            (object) [
                'kode' => 'TF8603',
                'nama_mk' => 'PENGOLAHAN CITRA DIGITAL',
                'status' => 'BARU',
                'hari' => 'Rabu',
                'jam_mulai' => '08:00:01',
                'jam_selesai' => '10:30:00',
                'sks' => 3,
            ],
            (object) [
                'kode' => 'TF6604',
                'nama_mk' => 'PENGAMANAN SISTEM KOMPUTER',
                'status' => 'BARU',
                'hari' => 'Rabu',
                'jam_mulai' => '10:30:01',
                'jam_selesai' => '13:00:00',
                'sks' => 3,
            ],
            (object) [
                'kode' => 'KM1004',
                'nama_mk' => 'PENGANTAR ENTERPRENEURSHIP',
                'status' => 'BARU',
                'hari' => 'Rabu',
                'jam_mulai' => '13:00:01',
                'jam_selesai' => '15:30:00',
                'sks' => 3,
            ],
            (object) [
                'kode' => 'TF5605',
                'nama_mk' => 'E-BUSINESS',
                'status' => 'BARU',
                'hari' => 'Jumat',
                'jam_mulai' => '12:10:01',
                'jam_selesai' => '14:40:00',
                'sks' => 3,
            ],
        ];

        // Hitung total SKS
        $totalSks = array_sum(array_map(fn($item) => $item->sks, $krsItems));

        // Data tambahan
        $ipsTerakhir = 3.813;
        $limitSks = 24;
        $toleransiSks = 0;
        $sisaLimit = $limitSks - $totalSks - $toleransiSks;
    @endphp

    <div class="container mx-auto p-4">
        <!-- Header -->
        <h1 class="text-2xl font-bold mb-2">KRS Anda yang Terdaftar</h1>
        <p class="mb-2">Berikut dibawah ini adalah daftar mata kuliah yang sudah anda daftarkan terakhir kali</p>

        <!-- Peringatan dengan link -->
        <div class="alert alert-warning mb-4 p-3 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700">
            <strong>Ingat!</strong> Untuk 
            <a href="#" class="text-blue-600 underline mx-1">Membatalkan</a>, 
            Silahkan memilih 
            <a href="#" class="text-blue-600 underline mx-1">Mata Kuliah</a> 
            dibawah ini. Jangan lupa untuk menverifikasikan serta mendiskusikannya kepada 
            <a href="#" class="text-blue-600 underline mx-1">Dosen Wali</a> 
            anda masing-masing.
        </div>

         <!-- Status Validasi dan Cetak KRS -->
        <div class="flex flex-wrap justify-between items-center mt-6 p-4 bg-gray-100 rounded-lg">
            <div class="flex items-center space-x-2">
                <span class="text-green-700 font-semibold">Status:</span>
                <span class="badge badge-success bg-green-600 text-white px-3 py-1 rounded-full">KRS Anda Telah Tervalidasi</span>
            </div>
            <button class="btn btn-primary bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md shadow">
                Cetak KRS
            </button>
        </div>

        <!-- Tabel KRS -->
        <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100 shadow-md">
            <table class="table w-full">
                <thead class="bg-transparent text-white">
                    <tr>
                        <th class="px-4 py-2">No</th>
                        <th class="px-4 py-2">Kode</th>
                        <th class="px-4 py-2">Mata Kuliah</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Jadwal (WIB)</th>
                        <th class="px-4 py-2">SKS</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($krsItems as $index => $item)
                        <tr class="border-b hover:cursor-pointer hover:bg-black/100">
                            <td class="px-4 py-2">{{ $index + 1 }}</td>
                            <td class="px-4 py-2">{{ $item->kode }}</td>
                            <td class="px-4 py-2">{{ $item->nama_mk }}</td>
                            <td class="px-4 py-2">
                                <span class="badge badge-success text-white bg-green-500 px-2 py-1 rounded">{{ $item->status }}</span>
                            </td>
                            <td class="px-4 py-2">{{ $item->hari }}, {{ $item->jam_mulai }}-{{ $item->jam_selesai }}</td>
                            <td class="px-4 py-2 text-center">{{ $item->sks }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Total SKS -->
        <div class="flex justify-end mt-4 font-bold text-lg">
            TOTAL {{ $totalSks }}
        </div>

        <!-- Informasi Tambahan -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6 p-4 bg-white border rounded-lg shadow-sm">
            <div class="text-center">
                <p class="text-gray-500 text-sm">Nilai IPS terakhir</p>
                <p class="font-bold text-lg">{{ $ipsTerakhir }}</p>
            </div>
            <div class="text-center">
                <p class="text-gray-500 text-sm">Limit SKS anda</p>
                <p class="font-bold text-lg">{{ $limitSks }} SKS</p>
            </div>
            <div class="text-center">
                <p class="text-gray-500 text-sm">Toleransi SKS anda</p>
                <p class="font-bold text-lg">{{ $toleransiSks }} SKS</p>
            </div>
            <div class="text-center">
                <p class="text-gray-500 text-sm">Sisa Limit SKS anda</p>
                <p class="font-bold text-lg text-blue-600">{{ $sisaLimit }} SKS</p>
            </div>
        </div>
    </div>
</x-layout>