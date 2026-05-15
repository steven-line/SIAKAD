@props([
'title' => 'KRS'])

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$title}}</title>
     @vite('resources/css/app.css')
  </head>
</head>
<body class="flex min-h-screen">
  <nav class="bg-white shadow-md border-r border-gray-200 h-screen  top-0 left-0 min-w-[250px] py-6 px-4 overflow-auto dark:bg-black">
      <div class="relative flex flex-col h-full">

        <div class="flex flex-col gap-y-2 justify-center items-center cursor-pointer relative">
          <img src="{{ asset('images/boy.png')}}" alt="boy" class="w-20 h-20">
          <p class="lg font-bold">Dummy</p>
        </div>

        <hr class="my-6 border-gray-200" />

        <div>
          
          <ul class="[&>li]:py-2 [&>li]:hover:bg-gray-100 flex-1">
            @can('dosen_wali')
              <li><a href="/dosen">Dashboard</a></li>
              <li><a href="/dosen/perwalian">Perwalian</a></li>
            @endcan
            @can('admin')
                <li><a href="/admin">Dashboard</a></li>
                <li><a href="/admin/kelola-user">Kelola User</a></li>
                <li><a href="/admin/kelola-matakuliah">Kelola Mata Kuliah</a></li>
                <li><a href="/admin/kelola-dosen">Kelola Dosen</a></li>
            @endcan
           @can('mahasiswa')
                <li><a href="/mahasiswa">Dashboard</a></li>
                <li><a href="/mahasiswa/penawaran">Penawaran</a></li>
                <li><a href="/mahasiswa/view_krs">KRS</a></li>
                <li><a href="/mahasiswa/ubah-password">Ubah Password</a></li>
            @endcan
            @can('kaprodi')
                <li>
                    <a href="/kaprodi"
                      class="block p-3 rounded hover:bg-gray-800 {{ request()->is('kaprodi') ? 'bg-blue-600' : '' }}">
                        🏠 Dashboard Kaprodi
                    </a>
                </li>

                <li>
                    <a href="{{ route('kaprodi.penawaran.create') }}"
                      class="block p-3 rounded hover:bg-gray-800 {{ request()->is('kaprodi/penawaran/create') ? 'bg-blue-600' : '' }}">
                        📄 Input Penawaran
                    </a>
                </li>

                <li>
                    <a href="/kaprodi/kelola_jadwal"
                      class="block p-3 rounded hover:bg-gray-800 {{ request()->is('kaprodi/kelola_jadwal') ? 'bg-blue-600' : '' }}">
                        📅 Jadwal
                    </a>
                </li>

                <li>
                    <a href="/kaprodi/jadwal_pagi"
                      class="block p-3 rounded hover:bg-gray-800 {{ request()->is('kaprodi/jadwal_pagi') ? 'bg-blue-600' : '' }}">
                        🌅 Jadwal Pagi
                    </a>
                </li>

                <li>
                    <a href="/kaprodi/jadwal_malam"
                      class="block p-3 rounded hover:bg-gray-800 {{ request()->is('kaprodi/jadwal_malam') ? 'bg-blue-600' : '' }}">
                        🌙 Jadwal Malam
                    </a>
                </li>

            @endcan
              @auth
                <form action="/logout" method="POST">
                  @csrf
                  @method('DELETE')
                  <li class="hover:bg-gray-100 py-2"><button>Log Out</button></li>
                  
                </form>           
              @endauth
         
          </ul>
        </div>

        <li></li>

        <hr class="my-6 border-gray-200" />

        
      
      </div>
    </nav>
     

  <main class="flex-1 px-4 py-6">
    {{$slot}}
  </main>
</body>
</html>