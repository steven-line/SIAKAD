<x-layout>
<div class="flex justify-center items-center">
    <div class="card bg-base-200 border border-base-300 shadow-xl w-8/10 mx-auto p-8">

        <h1 class="font-bold text-2xl">Detail Jurusan</h1>

        <div class="card-body">
            <div class="grid grid-rows-2 gap-4">

                <div class="grid grid-cols-2 gap-4">

                    <div>
                        <p class="font-semibold text-base-content/70">Kode Jurusan</p>
                        <p class="text-lg">{{ $jurusan->kode_jurusan }}</p>
                    </div>

                    <div>
                        <p class="font-semibold text-base-content/70">Nama Jurusan</p>
                        <p class="text-lg">{{ $jurusan->nama_jurusan ?? '-' }}</p>
                    </div>

                    <div>
                        <p class="font-semibold text-base-content/70">Program Pendidikan</p>
                        <p class="text-lg">{{ $jurusan->program_pendidikan }}</p>
                    </div>

                    <div>
                        <p class="font-semibold text-base-content/70">SK BAN</p>
                        <p class="text-lg">{{ $jurusan->sk_ban }}</p>
                    </div>

                    <div>
                        <p class="font-semibold text-base-content/70">Fakultas</p>
                        <p class="text-lg">{{ $jurusan->fakultas->nama_fakultas ?? '-' }}</p>
                    </div>

                    <div>
                        <p class="font-semibold text-base-content/70">Keterangan</p>
                        <p class="text-lg">{{ $jurusan->keterangan ?? '-' }}</p>
                    </div>

                </div>

                <div class="mt-5">
                    <a class="btn btn-primary"
                       href="{{ route('jurusan.index') }}">
                        Kembali
                    </a>

                    <a class="btn btn-warning"
                       href="{{ route('jurusan.edit', $jurusan->kode_jurusan) }}">
                        Edit
                    </a>
                </div>

            </div>
        </div>

    </div>
</div>
</x-layout>