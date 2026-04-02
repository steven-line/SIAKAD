<!DOCTYPE html>
<html>
<head>
    <title>Jadwal Mata Kuliah</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="p-6">
    <h1 class="text-2xl font-bold mb-6">Jadwal Mata Kuliah</h1>

    @php
        // Gabungkan semua data
        $all = collect()
            ->merge($jadwal_univ)
            ->merge($jadwal_umum)
            ->merge($jadwal_prodi);

        $grouped = $all->groupBy('hari');

        function warnaKategori($kategori) {
            switch ($kategori) {
                case 'univ': return 'bg-red-500';
                case 'umum': return 'bg-blue-500';
                case 'prodi': return 'bg-green-500';
                default: return 'bg-gray-500';
            }
        }
    @endphp

    @foreach($grouped as $hari => $items)

        <!-- Judul Hari -->
        <h2 class="inline-block bg-gray-800 text-white px-3 py-1 rounded mb-2 mt-6">
            {{ strtoupper($hari) }}
        </h2>

        <!-- Tabel -->
        <table class="w-full border text-sm bg-white shadow">
            <thead class="bg-gray-200">
                <tr>
                    <th class="p-2 w-10">No</th>
                    <th class="p-2">Kode</th>
                    <th class="p-2">Mata Kuliah</th>
                    <th class="p-2">Hari</th>
                    <th class="p-2">Pukul (WIB)</th>
                    <th class="p-2">SKS</th>
                </tr>
            </thead>
            <tbody>

                @foreach($items as $index => $j)
                <tr class="border-t text-center hover:bg-gray-50">
                    <td class="p-2">{{ $index + 1 }}</td>
                    <td class="p-2">{{ $j->kodemk }}</td>

                    <!-- Nama + badge kategori -->
                    <td class="p-2 text-left">
                        {{ strtoupper($j->nama_mk) }}

                        <span class="text-white text-xs px-2 py-1 rounded ml-2 {{ warnaKategori($j->kategori) }}">
                            {{ strtoupper($j->kategori) }}
                        </span>
                    </td>

                    <td class="p-2">{{ strtoupper($j->hari) }}</td>
                    <td class="p-2">{{ $j->jam_mulai }} - {{ $j->jam_selesai }}</td>

                    <!-- SKS + kategori kecil -->
                    <td class="p-2">
                        {{ $j->sks }}
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>

    @endforeach

</div>

</body>
</html>