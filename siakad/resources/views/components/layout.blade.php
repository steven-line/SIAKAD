@props(['title' => 'KRS'])

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    @vite('resources/css/app.css')
</head>

<body class="flex min-h-screen">

<nav class="bg-white shadow-md border-r border-gray-200 h-screen sticky top-0 left-0 min-w-[250px] py-6 px-4 dark:bg-black">

<div class="flex flex-col h-full">

    <div class="flex flex-col items-center gap-2">
        <img src="{{ asset('images/boy.png') }}" class="w-20 h-20" alt="user">
        <span class="font-bold text-lg">
            @php
                $user = auth()->user();
                $displayName = $user->username ?? 'Guest';
                if ($user && $user->hasRole('mahasiswa')) {
                    $nama = DB::table('biodata')->where('nrp', $user->username)->value('nama');
                    if ($nama) {
                        $displayName = $nama;
                    }
                }
            @endphp
            {{ $displayName }}
        </span>
    </div>

    <hr class="my-6 border-gray-200"/>

    <ul class="flex-1 [&>li]:py-2">

        {{-- DASHBOARD (SEMUA USER) --}}
        <li>
            <a href="/dashboard">Dashboard</a>
        </li>

        {{-- ADMIN --}}
        @can('user.manage')
        <li><a href="/users">Master User</a></li>
        @endcan

        @can('kurikulum.manage')
        <li><a href="/kurikulum">Master Kurikulum</a></li>
        @endcan

        @can('mk.manage')
        <li><a href="/matakuliah">Master Mata Kuliah</a></li>
        @endcan

        @can('dosen.manage')
        <li><a href="/dosen">Master Dosen</a></li>
        @endcan

        @can('prodi.manage')
        <li><a href="/prodi">Master Prodi</a></li>
        @endcan

        @can('fakultas.manage')
        <li><a href="/fakultas">Master Fakultas</a></li>
        @endcan

        @can('biodata.manage')
        <li><a href="/biodata">Master Biodata</a></li>
        @endcan

        {{-- ROLE & PERMISSION --}}
        @can('role.manage')
        <li><a href="/roles">Master Role</a></li>
        @endcan

        @can('permission.manage')
        <li><a href="/permissions">Master Permission</a></li>
        @endcan

        {{-- DOSEN INPUT NILAI --}}
        @can('nilai.input')
        <li><a href="/input-nilai">Input Nilai</a></li>
        @endcan

        {{-- MAHASISWA --}}
        @can('biodata.view')
        <li><a href="/mahasiswa/biodata">Biodata</a></li>
        @endcan

        @can('krs.view')
        <li><a href="/mahasiswa/krs">KRS</a></li>
        @endcan

        @can('penawaran.view')
        <li><a href="/mahasiswa/penawaran">Penawaran</a></li>
        @endcan

        @can('nilai_krs.view')
        <li><a href="/mahasiswa/nilai-krs">Nilai KRS</a></li>
        @endcan

        @can('khs.view')
        <li><a href="/mahasiswa/khs">KHS</a></li>
        @endcan

        @can('transkrip.view')
        <li><a href="/mahasiswa/transkrip">Transkrip</a></li>
        @endcan

        {{-- PERWALIAN --}}
        @can('perwalian.manage')
        <li><a href="/perwalian">Perwalian</a></li>
        @endcan

        {{-- KAPRODI (jadwal/penawaran pakai permission juga) --}}
        @can('jadwal.manage')
        <li><a href="/jadwal">Jadwal</a></li>
        <li><a href="/jadwal/pagi">Jadwal Pagi</a></li>
        <li><a href="/jadwal/malam">Jadwal Malam</a></li>
        @endcan

        @can('penawaran.manage')
        <li><a href="/penawaran">Penawaran</a></li>
        @endcan

        {{-- LOGOUT --}}
        @auth
        <hr class="my-4 border-gray-200" />

        <form action="/logout" method="POST">
            @csrf
            @method('DELETE')

            <li class="text-red-600 hover:bg-red-100 rounded">
                <button class="w-full text-left px-2 py-2">
                    Logout
                </button>
            </li>
        </form>
        @endauth

    </ul>

</div>

</nav>

<main class="flex-1 px-4 py-6 overflow-y-auto">
    {{ $slot }}
</main>

</body>
</html>