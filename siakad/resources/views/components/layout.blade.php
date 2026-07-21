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

<nav class="bg-white shadow-md border-r border-gray-200
            h-screen sticky top-0 left-0
            min-w-[250px] dark:bg-black">

    <div class="flex flex-col h-full">

        {{-- PROFILE --}}
        <div class="py-6 px-4 flex flex-col items-center gap-2">

            @php
                use Illuminate\Support\Facades\DB;

                $user = auth()->user();

                $displayName = 'Guest';
                $displayId = '';
                $displayRole = '';

                if ($user) {

                    $displayName = $user->username;
                    $displayId = $user->username;

                    $biodata = DB::table('biodata')
                        ->where('nrp', $user->username)
                        ->first();

                    if ($biodata) {
                        $displayName = $biodata->nama;
                        $displayId = $biodata->nrp;
                    }

                    $dosen = DB::table('dosen')
                        ->where('nim_dosen', trim($user->username))
                        ->first();

                    if ($dosen) {
                        $displayName = $dosen->nama;
                        $displayId = $dosen->nim_dosen;
                    }

                    $displayRole = $user->roles->pluck('name')->join(', ');
                }
            @endphp

            <img src="{{ asset('images/boy.png') }}"
                 class="w-20 h-20"
                 alt="user">

            <span class="font-bold text-lg text-center">
                {{ $displayName }}
            </span>

            <span class="text-sm text-gray-500">
                {{ $displayId }}
            </span>

            <span class="badge badge-primary mt-1">
                {{ ucfirst($displayRole) }}
            </span>

        </div>

        <hr class="border-gray-200">

        {{-- MENU --}}
        <div class="flex-1 overflow-y-auto px-4 py-4">

            <ul class="[&>li]:py-2">

        {{-- DASHBOARD (SEMUA USER) --}}
        <li>
            <a href="/dashboard">Dashboard</a>
        </li>

        {{-- ADMIN --}}
        @can('user.manage')
        <li><a href="/users">Master User</a></li>
        @endcan

        @can('settings.manage')
        <li><a href="/metaperiode">Master Settings</a></li>
        @endcan
           {{-- ROLE & PERMISSION --}}
           
        @can('permission.manage')
        <li><a href="/permissions">Master Permission</a></li>
        @endcan
        @can('role.manage')
        <li><a href="/roles">Master Role</a></li>
        @endcan

        @can('kurikulum.manage')
        <li><a href="/kurikulum">Master Kurikulum</a></li>
        @endcan
        @can('fakultas.manage')
        <li><a href="/fakultas">Master Fakultas</a></li>
        @endcan
        @can('mk.manage')
        <li><a href="/matakuliah">Master Mata Kuliah</a></li>
        @endcan

        @can('prodi.manage')
        <li><a href="/prodi">Master Prodi</a></li>
        @endcan
        
        @can('dosen.manage')
        <li><a href="/dosen">Master Dosen</a></li>
        @endcan

        @can('mahasiswa.manage')
        <li><a href="/mahasiswa-admin">Master Mahasiswa</a></li>
        @endcan
     

        @can('biodata.manage')
          <li><a href="/biodata">Master Biodata</a></li>
        @endcan

        @can('jurusan.manage')
          <li><a href="/jurusan">Master Jurusan</a></li>
        @endcan

        @can('periode.manage')
            <li><a href="/periode">Master Periode</a></li>
        @endcan

        @can('semester.manage')
            <li><a href="/semester">Master Semester</a></li>
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
        <li><a href="/mahasiswa/nilai_krs">Nilai KRS</a></li>
        @endcan

        @can('khs.view')
        <li><a href="/mahasiswa/khs">KHS</a></li>
        @endcan

        @can('transkrip.view')
        <li><a href="/mahasiswa/transkrip">Transkrip Nilai</a></li>
        @endcan

        {{-- PERWALIAN --}}
        @can('perwalian.manage')
        <li><a href="/perwalian">Perwalian</a></li>
        <li><a href="/nilai_krs_anak_wali">Nilai Krs Anak Wali</a></li>
        <li><a href="/nilai_khs_anak_wali">Nilai Khs Anak Wali</a></li>
        <li><a href="/transkrip_nilai_anak_wali">Transkrip Nilai Anak Wali</a></li>
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
        @can('pjmk.manage')
        <li><a href="/pjmk">PJMK</a></li>
        @endcan
        {{-- KEUANGAN --}}
        @can('blokir.keuangan')
        <li><a href="{{ route('keuangan.mahasiswa.index') }}">Keuangan</a></li>
        @endcan
            </ul>

        </div>

        {{-- LOGOUT --}}
        @auth
        <div class="border-t border-gray-200 p-4">

            <form action="/logout" method="POST">
                @csrf
                @method('DELETE')

                <button
                    type="submit"
                    class="w-full rounded-lg bg-red-500 hover:bg-red-600 text-white py-2 transition">
                    Logout
                </button>

            </form>

        </div>
        @endauth

    </div>

</nav>

<main class="flex-1 px-4 py-6 overflow-y-auto">
    {{ $slot }}
</main>

</body>
</html>