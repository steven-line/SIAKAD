<x-layout title="KHS Mahasiswa">
    @if(in_array($statusBlokir, ['BLOKIR','TERKUNCI']))
        <div role="alert"
             class="alert {{ $statusBlokir == 'BLOKIR' ? 'alert-error' : 'alert-warning' }} mb-6">

            <svg xmlns="http://www.w3.org/2000/svg"
                 class="h-6 w-6 shrink-0 stroke-current"
                 fill="none"
                 viewBox="0 0 24 24">

                @if($statusBlokir == 'BLOKIR')
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                @else
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M13 16h-1v-4h-1m1-4h.01M12 22a10 10 0 100-20 10 10 0 000 20z"/>
                @endif
            </svg>

            <span>
                @if($statusBlokir == 'BLOKIR')
                    KRS anda terkunci, mohon hubungi bagian keuangan untuk menyelesaikan tunggakan.
                @else
                    KRS Anda sedang terkunci. Anda masih dapat melihat data KHS, tetapi tidak dapat melakukan perubahan KRS.
                @endif
            </span>
        </div>
    @endif

    <div class="container mx-auto p-4">
        <!-- Header -->
        <h1 class="text-2xl font-bold mb-2 text-white">KRS Anda yang Terdaftar</h1>
        <p class="mb-2 text-white">Berikut adalah daftar mata kuliah yang sudah anda daftarkan. Centang mata kuliah yang ingin dibatalkan, lalu klik tombol "Batalkan yang Dipilih".</p>

        <!-- Peringatan -->
        <div class="alert alert-warning mb-4 p-3 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700">
            <strong>Ingat!</strong> Sebelum membatalkan, diskusikan dengan 
            <a href="#" class="text-blue-600 underline mx-1">Dosen Wali</a> anda.
        </div>

        <div class="bg-white p-4 rounded-lg shadow mb-4 text-black">
            <div class="grid grid-cols-2 gap-4">
                <div><strong>NRP</strong> : {{ $nrp }}</div>

                <div><strong>Nama</strong> : {{ $mahasiswa->biodata->nama ?? '-' }}</div>

                <div><strong>Program Studi</strong> : {{ $mahasiswa->prodi ?? '-' }}</div>
                <div><strong>Dosen Wali</strong> : {{ $mahasiswa->dosenWali->nama ?? '-' }}</div>
            </div>
        </div>
        

            <!-- Status Validasi dan Cetak KRS -->
            <div class="flex flex-wrap justify-between items-center mt-6 p-4 bg-gray-100 rounded-lg">
                <div class="flex items-center space-x-2">
                    <span class="text-green-700 font-semibold">Status:</span>
                    <span class="bg-green-600 text-white px-3 py-1 rounded-full text-sm">
                        {{ $statusBlokir ?? 'KRS Anda Telah Tervalidasi' }}
                    </span>
                </div>
                <div class="flex gap-2">
                   @if ($statusBlokir === 'BELUM_KRS')
                            <button type="submit"
                                    form="validasi-mahasiswa-form-{{ $nrp }}"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md shadow">
                                Submit
                            </button>
                        @endif
                    <button type="button" id="cetakKRS" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md shadow">
                        Cetak KRS
                    </button>
                </div>
            </div>
       
            <!-- Tabel KRS -->
            <div class="overflow-x-auto rounded-box border border-base-content/5 bg-white shadow-md mt-4">
                <table class="table w-full">
                    <thead class="bg-blue-500 text-white">
                        <tr>
                            <th class="px-4 py-2">No</th>
                            <th class="px-4 py-2">Kode</th>
                            <th class="px-4 py-2">Mata Kuliah</th>
                            <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2">Jadwal (WIB)</th>
                            <th class="px-4 py-2">SKS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($krsItems ?? [] as $index => $item)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-2 text-black">{{ $index + 1 }}</td>
                            <td class="px-4 py-2 text-black">
                                <a href="{{ route('mahasiswa.mata_kuliah.show',  $item->recno) }}">
                                    {{ $item->kode_mk }}
                                </a>
                            </td>
                            <td class="px-4 py-2 text-black">
                                <a href="{{ route('mahasiswa.mata_kuliah.show',  $item->recno) }}">
                                    {{ $item->nama_mk }}
                                </a>
                            </td>
                            <td class="px-4 py-2">
                                <span class="bg-green-500 text-white px-2 py-1 rounded text-sm">{{ $item->status }}</span>
                            </td>
                            <td class="px-4 py-2 text-black">
                                <a href="{{ route('mahasiswa.mata_kuliah.show',  $item->recno) }}">
                                    {{ $item->hari }}, {{ $item->jam_mulai }}-{{ $item->jam_selesai }}
                                </a>
                            </td>
                            <td class="px-4 py-2 text-black text-center">
                                <a href="{{ route('mahasiswa.mata_kuliah.show',  $item->recno) }}">
                                    {{ $item->sks }}
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">Belum ada mata kuliah yang dipilih.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>
        
        <form id="validasi-mahasiswa-form-{{$nrp}}" 
              action="{{ route('mahasiswa.krs.validasi', $nrp) }}" 
              method='POST'>
              @csrf
        </form>
        <!-- Total SKS -->
        <div class="flex justify-end mt-4 font-bold text-lg">
            TOTAL {{ $totalSks }} SKS
        </div>

        <!-- Informasi Tambahan -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6 p-4 bg-white border rounded-lg shadow-sm">
            <div class="text-center">
                <p class="text-blue-500 text-sm">Nilai IPS terakhir</p>
                <p class="font-bold text-lg text-blue-600">{{ $ipsTerakhir }}</p>
            </div>
            <div class="text-center">
                <p class="text-blue-500 text-sm">Limit SKS anda</p>
                <p class="font-bold text-lg text-blue-600">{{ $limitSks }} SKS</p>
            </div>
            <div class="text-center">
                <p class="text-blue-500 text-sm">Toleransi SKS anda</p>
                <p class="font-bold text-lg text-blue-600">{{ $toleransiSks }} SKS</p>
            </div>
            <div class="text-center">
                <p class="text-blue-500 text-sm">Sisa Limit SKS anda</p>
                <p class="font-bold text-lg text-blue-600">{{ $sisaLimit }} SKS</p>
            </div>
        </div>
    </div>
</x-layout>