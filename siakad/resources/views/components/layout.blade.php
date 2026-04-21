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

        <div class="flex flex-wrap items-center cursor-pointer relative">
          <img src='https://readymadeui.com/readymadeui-short.svg' class="w-10 h-10" />

          <div class="ml-4">
            <p class="text-sm text-slate-900 font-medium">Test</p>
           
          </div>
          <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 absolute right-0 fill-gray-400" viewBox="0 0 55.752 55.752">
            <path
              d="M43.006 23.916a5.36 5.36 0 0 0-.912-.727L20.485 1.581a5.4 5.4 0 0 0-7.637 7.638l18.611 18.609-18.705 18.707a5.398 5.398 0 1 0 7.634 7.635l21.706-21.703a5.35 5.35 0 0 0 .912-.727 5.373 5.373 0 0 0 1.574-3.912 5.363 5.363 0 0 0-1.574-3.912z"
              data-original="#000000" />
          </svg>
        </div>

        <hr class="my-6 border-gray-200" />

        <div>
          
          <ul class="space-y-4 flex-1">
            @can('dosen_wali')
              <li><a href="/dosen">Dashboard</a></li>
              <li><a href="/dosen/perwalian">Perwalian</a></li>
            @endcan
            @can('admin')
                <li><a href="/admin">Dashboard</a></li>
                <li><a href="/admin/kelola-user">Kelola User</a></li>
            @endcan
           @can('mahasiswa')
                <li><a href="/mahasiswa">Dashboard</a></li>
                <li><a href="/mahasiswa/penawaran">Penawaran</a></li>
                <li><a href="/mahasiswa/view_krs">KRS</a></li>
                <li><a href="/mahasiswa/ubah-password">Ubah Password</a></li>
            @endcan
            @can('kaprodi')
                <li><a href="/kaprodi">Dashboard Kaprodi</a></li>
                <li><a href="/kaprodi/jadwal">KRS</a></li>
            @endcan
     
            
              @auth
                <form action="/logout" method="POST">
                  @csrf
                  @method('DELETE')
                  <li><button>Log Out</button></li>
                  
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