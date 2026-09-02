<x-layout>

    <div class="p-6 max-w-4xl mx-auto">

       <!-- Tombol Kembali (Aman untuk Dark/Light Mode) -->
       <a class="join-item btn btn-primary btn-outline gap-2 mb-6 normal-case shadow-sm" href="{{ route('mahasiswa_transfer.index') }}">
            <svg xmlns="http://w3.org" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Previous page
       </a>

        <!-- Card Utama Transkrip -->
        <div class="card bg-base-100 border border-base-300 shadow-xl max-w-2xl mx-auto">

            <div class="card-body p-8">

                <!-- Header Halaman Transkrip -->
                <div class="flex items-center justify-between mb-2">
                    <div>
                        <h2 class="card-title text-xl font-bold tracking-tight text-base-content">Transkrip Nilai Transfer</h2>
                        <p class="text-xs text-base-content/60 mt-0.5">Lembar rekaman hasil konversi mata kuliah</p>
                    </div>
                    <!-- Badge Total Mata Kuliah Adaptif -->
                    <div class="badge badge-neutral font-mono font-semibold p-3 text-xs text-neutral-content">
                        Total MK: {{ $nilaiTransfer->count() }}
                    </div>
                </div>

                <div class="divider opacity-60 my-4"></div>

                <!-- List Nilai Berbasis Baris Vertikal Tunggal -->
                <div class="grid grid-cols-1 gap-1">

                    @forelse($nilaiTransfer as $index => $item)
                        <!-- Baris Transkrip Kebawah dengan Batas Warna Transparan Adaptif -->
                        <div class="flex items-center justify-between py-3 px-4 rounded-lg hover:bg-base-200/60 transition-colors duration-150 border-b border-base-content/10 last:border-0">
                            
                            <!-- Bagian Kiri: Nomor, Kode MK, dan NRP -->
                            <div class="flex items-center gap-4">
                                <!-- Nomor Urut -->
                                <span class="w-6 text-xs font-mono text-base-content/40 text-center font-bold">
                                    {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                                </span>
                                
                                <!-- Kode MK & Informasi Mahasiswa -->
                                <div>
                                    <div class="font-mono font-bold text-sm tracking-wide text-base-content">{{ $item->kodemk }}</div>
                                    <div class="text-[11px] text-base-content/50 font-mono mt-0.5">NRP: {{ $item->nrp }}</div>
                                </div>
                            </div>
                            
                            <!-- Bagian Kanan: Bobot SKS dan Nilai Akhir -->
                            <div class="flex items-center gap-8 text-right">
                                <!-- Bobot SKS -->
                                <div class="text-xs font-medium text-base-content/70 font-mono">
                                    {{ $item->sks }} SKS
                                </div>
                                
                                <!-- Nilai Akhir Huruf dengan Kontras Warna Khusus Mode Gelap/Terang -->
                                <div class="w-10 text-center font-mono font-black text-base tracking-wide
                                    {{ in_array($item->na, ['A', 'AB', 'B']) ? 'text-success dark:text-success-content' : 'text-warning dark:text-warning-content' }}">
                                    {{ $item->na }}
                                </div>
                            </div>
                            
                        </div>
                    @empty
                        <!-- State Jika Data Kosong (Menggunakan warna dasar sistem) -->
                        <div class="text-center py-12 bg-base-200/30 rounded-xl border border-dashed border-base-300 mt-2">
                            <svg xmlns="http://w3.org" class="h-12 w-12 mx-auto text-base-content/20 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <p class="text-sm font-medium text-base-content/50">Belum ada rekaman transkrip nilai transfer.</p>
                        </div>
                    @endforelse

                </div>

            </div>

        </div>

    </div>

</x-layout>
