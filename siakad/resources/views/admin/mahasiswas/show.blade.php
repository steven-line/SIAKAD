<x-layout>

    <div class="p-6">

       
       <a class="join-item btn btn-primary mb-4" href="{{ route('mahasiswa_admin.index') }}">
        ⮜ Previous page
    </a>

        <div class="card bg-base-200 border border-base-300 shadow-xl max-w-3xl mx-auto">

            <div class="card-body">

                <h2 class="card-title text-2xl font-bold mb-4">
                    Detail Mahasiswa
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Kode Kurikulum --}}
                    <div>
                        <p class="font-semibold text-base-content/70">
                            NRP
                        </p>
                        <p class="text-lg">
                            {{ $mahasiswa->nrp }}
                        </p>
                    </div>

                    {{-- Nama Kurikulum --}}
                    <div>
                        <p class="font-semibold text-base-content/70">
                            Dosen Wali
                        </p>
                        <p class="text-lg">
                            {{ $mahasiswa->dosen_wali }}
                        </p>
                    </div>

                    {{-- Tahun Mulai --}}
                    <div>
                        <p class="font-semibold text-base-content/70">
                            Status Blokir
                        </p>
                        <p class="mt-3 badge badge-soft badge-success">
                            {{ $mahasiswa->status_blokir }}
                        </p>
                    </div>

                      <div>
                        <p class="font-semibold text-base-content/70">
                            Prodi
                        </p>
                        <p class="mt-3 badge badge-soft badge-primary">
                            {{ $mahasiswa->prodi }}
                        </p>
                    </div>
                </div>

                {{-- Deskripsi --}}
                

                {{-- Tombol --}}
                <div class="card-actions justify-end mt-6">

                    <a
                        href="{{ route('mahasiswa_admin.edit', $mahasiswa->nrp) }}"
                        class="btn btn-warning"
                    >
                        Edit
                    </a>

            

                </div>

            </div>

        </div>

    </div>

</x-layout>