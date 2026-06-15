<x-layout>
<div class="min-h-screen bg-gray-900 p-6 text-white">

    <div class="mb-8">
        <h1 class="text-3xl font-bold">
            Selamat datang, {{ auth()->user()->dosen->nama }}
        </h1>
        <p class="text-gray-400 mt-1">
            Sistem Informasi Akademik - Dashboard Dosen ({{ auth()->user()->dosen->prodi }})
        </p>
    </div>

    <div class="bg-gray-800 p-6 rounded-lg shadow max-w-md">
        <h2 class="font-semibold mb-4 text-lg text-primary">Informasi Akun Dosen</h2>

        <div class="space-y-2 text-gray-300">
            <p><strong>Nama Lengkap:</strong> {{ auth()->user()->dosen->nama }}</p>
            <p><strong>NIP / NIM Dosen:</strong> {{ auth()->user()->dosen->nip }} / {{ auth()->user()->dosen->nim_dosen }}</p>
            <p><strong>Username Akun:</strong> {{ auth()->user()->username }}</p>
            <p><strong>Program Studi:</strong> <span class="badge badge-primary">{{ auth()->user()->dosen->prodi }}</span></p>
            <p><strong>Level Akses:</strong> {{auth()->user()->getRoleNames()->implode(', ')}}</p>
        </div>
    </div>

  

</div>
</x-layout>