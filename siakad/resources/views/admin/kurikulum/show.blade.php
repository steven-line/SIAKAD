<x-layout>

    <div class="p-6">

        <a class="btn btn-primary mb-6" href="/admin/kelola-kurikulum">
            ⮜ Previous page
        </a>

        <div class="card bg-base-200 border border-base-300 shadow-xl max-w-3xl mx-auto">

            <div class="card-body">

                <h2 class="card-title text-2xl font-bold mb-4">
                    Detail Kurikulum
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Kode Kurikulum --}}
                    <div>
                        <p class="font-semibold text-base-content/70">
                            Kode Kurikulum
                        </p>
                        <p class="text-lg">
                            {{ $kurikulum->kode_kurikulum }}
                        </p>
                    </div>

                    {{-- Nama Kurikulum --}}
                    <div>
                        <p class="font-semibold text-base-content/70">
                            Nama Kurikulum
                        </p>
                        <p class="text-lg">
                            {{ $kurikulum->nama_kurikulum }}
                        </p>
                    </div>

                    {{-- Status Aktif --}}
                    <div>
                        <p class="font-semibold text-base-content/70">
                            Status
                        </p>

                        @if($kurikulum->aktif)
                            <div class="badge badge-success">
                                Aktif
                            </div>
                        @else
                            <div class="badge badge-error">
                                Tidak Aktif
                            </div>
                        @endif
                    </div>

                    {{-- Tahun Mulai --}}
                    <div>
                        <p class="font-semibold text-base-content/70">
                            Tahun Mulai Berlaku
                        </p>
                        <p class="text-lg">
                            {{ $kurikulum->tahun_mulai_berlaku }}
                        </p>
                    </div>

                    {{-- Tahun Selesai --}}
                    <div>
                        <p class="font-semibold text-base-content/70">
                            Tahun Selesai Berlaku
                        </p>
                        <p class="text-lg">
                            {{ $kurikulum->tahun_selesai_berlaku }}
                        </p>
                    </div>

                </div>

                {{-- Deskripsi --}}
                <div class="mt-6">

                    <p class="font-semibold text-base-content/70 mb-2">
                        Deskripsi
                    </p>

                    <div class="bg-base-100 border border-base-300 rounded-box p-4 whitespace-pre-line">
                        {{ $kurikulum->deskripsi }}
                    </div>

                </div>

                {{-- Tombol --}}
                <div class="card-actions justify-end mt-6">

                    <a
                        href="/admin/kelola-kurikulum/{{$kurikulum->kode_kurikulum}}/edit"
                        class="btn btn-warning"
                    >
                        Edit
                    </a>

                    <a
                        href="/admin/kelola-kurikulum"
                        class="btn btn-primary"
                    >
                        Kembali
                    </a>

                </div>

            </div>

        </div>

    </div>

</x-layout>