@props(['title' => 'KRS'])

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$title}}</title>
    @vite('resources/css/app.css')
</head>
<body class="flex min-h-screen">
  <nav class="bg-white shadow-md border-r border-gray-200 h-screen sticky  top-0 left-0 min-w-[250px] py-6 px-4  dark:bg-black">
      <div class="relative flex flex-col h-full">

        <div class="flex flex-col gap-y-2 justify-center items-center cursor-pointer relative">
          <img src="{{ asset('images/boy.png')}}" alt="boy" class="w-20 h-20">
        </div>

        <hr class="my-6 border-gray-200"/>

        <div>
          <ul class="[&>li]:py-2 [&>li] flex-1">
            
            {{-- Perbaikan: Menggunakan @role untuk sidebar navigasi --}}
            
            @role('dosen-wali')
              <li><a href="/dosen-wali">Dashboard</a></li>
              <li><a href="/dosen-wali/perwalian">Perwalian</a></li>
            @endrole

            @role('admin')
              <li><a href="/admin">Dashboard</a></li>
              <li><a href="/admin/kelola-user">Kelola User</a></li>
              <li><a href="/admin/kelola-kurikulum">Kelola Kurikulum</a></li>
              <li><a href="/admin/kelola-matakuliah">Kelola Mata Kuliah</a></li>
              <li><a href="/admin/kelola-dosen">Kelola Dosen</a></li>
              <li><a href="/admin/kelola-prodi">Kelola Prodi</a></li>
              <li><a href="/admin/kelola-fakultas">Kelola Fakultas</a></li>
              <li><a href="/admin/kelola-biodata">Kelola Biodata</a></li>
              <li><a href="/admin/master-permission">Master Permission</a></li>
              <li><a href="/admin/master-role">Master Role</a></li>

            @endrole

            @role('mahasiswa')
              <li><a href="/mahasiswa" class="text-white">Dashboard</a></li>
              <li><a href="/mahasiswa/biodata" class="text-white">Biodata</a></li>
              <li><a href="/mahasiswa/penawaran" class="text-white">Penawaran</a></li>
              <li><a href="/mahasiswa/krs" class="text-white">KRS</a></li>
              <li><a href="/mahasiswa/nilai_krs" class="text-white">Nilai KRS</a></li>
              <li><a href="/mahasiswa/KHS" class="text-white">KHS</a></li>
              <li><a href="/mahasiswa/Transkrip_Nilai" class="text-white">Transkrip Nilai</a></li>
              <li><a href="/mahasiswa/ubah-password" class="text-black">Ubah Password</a></li>
            @endrole

            @role('kaprodi')
              <li>
                  <a href="/kaprodi" class="block p-3 rounded hover:bg-gray-800 {{ request()->is('kaprodi') ? 'bg-blue-600 text-white' : '' }}">
                      🏠 Dashboard Kaprodi
                  </a>
              </li>
              <li>
                  <a href="{{ route('kaprodi.penawaran.create') }}" class="block p-3 rounded hover:bg-gray-800 {{ request()->is('kaprodi/penawaran/create') ? 'bg-blue-600 text-white' : '' }}">
                      📄 Input Penawaran
                  </a>
              </li>
              <li>
                  <a href="{{ route('kaprodi.penawaran.index') }}" class="block p-3 rounded hover:bg-gray-800 {{ request()->is('kaprodi/penawaran/') ? 'bg-blue-600 text-white' : '' }}">
                      📄 List Penawaran
                  </a>
              </li>
              
              <li>
                  <a href="/kaprodi/kelola_jadwal" class="block p-3 rounded hover:bg-gray-800 {{ request()->is('kaprodi/kelola_jadwal') ? 'bg-blue-600 text-white' : '' }}">
                      📅 Jadwal
                  </a>
              </li>
              
              <li>
                  <a href="/kaprodi/jadwal_pagi" class="block p-3 rounded hover:bg-gray-800 {{ request()->is('kaprodi/jadwal_pagi') ? 'bg-blue-600 text-white' : '' }}">
                      🌅 Jadwal Pagi
                  </a>
              </li>
              <li>
                  <a href="/kaprodi/jadwal_malam" class="block p-3 rounded hover:bg-gray-800 {{ request()->is('kaprodi/jadwal_malam') ? 'bg-blue-600 text-white' : '' }}">
                      🌙 Jadwal Malam
                  </a>
              </li>
            @endrole

            {{-- Logout selalu tampil untuk user yang sudah login --}}
            @auth
              <hr class="my-4 border-gray-200" />
              <form action="/logout" method="POST">
                @csrf
                @method('DELETE')
                <li class="hover:bg-red-100 py-2 text-red-600">
                    <button type="submit" class="w-full text-left px-2">Log Out</button>
                </li>
              </form>          
            @endauth
          </ul>
        </div>
      </div>
  </nav>

  <main class="flex-1 px-4 py-6 overflow-y-auto">
    {{$slot}}
  </main>
</body>
</html>