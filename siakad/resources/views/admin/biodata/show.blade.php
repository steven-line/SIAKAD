<x-layout>
    <div class="flex justify-between items-center mb-4 max-w-4xl mx-auto">
        <a class="btn btn-primary" href="{{ route('biodata.index') }}">
            ⮜ Previous page
        </a>
        <a class="btn btn-warning" href="{{ route('biodata.edit', $biodata->nrp) }}">
            Edit Data ⮞
        </a>
    </div>

    <div class="bg-base-200 border-base-300 rounded-box w-full border p-6 mx-auto max-w-4xl mb-10">
        <h2 class="font-bold text-2xl mb-6 border-b border-base-300 pb-2">Detail Biodata Mahasiswa</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-4">
            
            <!-- Data Pribadi -->
            <div class="md:col-span-2">
                <h3 class="font-bold text-lg text-primary">Data Pribadi</h3>
            </div>

            <div>
                <span class="block text-sm font-bold opacity-70 mb-1">NRP</span>
                <span class="block px-3 py-2 bg-base-100 rounded-md border border-base-300">{{ $biodata->nrp }}</span>
            </div>

            <div>
                <span class="block text-sm font-bold opacity-70 mb-1">Nama</span>
                <span class="block px-3 py-2 bg-base-100 rounded-md border border-base-300">{{ $biodata->nama }}</span>
            </div>

            <div class="md:col-span-2">
                <span class="block text-sm font-bold opacity-70 mb-1">NIK</span>
                <span class="block px-3 py-2 bg-base-100 rounded-md border border-base-300">{{ $biodata->nik }}</span>
            </div>

            <div>
                <span class="block text-sm font-bold opacity-70 mb-1">Tempat Lahir</span>
                <span class="block px-3 py-2 bg-base-100 rounded-md border border-base-300">{{ $biodata->tempat_lahir ?? '-' }}</span>
            </div>

            <div>
                <span class="block text-sm font-bold opacity-70 mb-1">Tanggal Lahir</span>
                <span class="block px-3 py-2 bg-base-100 rounded-md border border-base-300">{{ $biodata->tanggal_lahir ? \Carbon\Carbon::parse($biodata->tanggal_lahir)->format('d F Y') : '-' }}</span>
            </div>

            <div>
                <span class="block text-sm font-bold opacity-70 mb-1">Jenis Kelamin</span>
                <span class="block px-3 py-2 bg-base-100 rounded-md border border-base-300">
                    {{ $biodata->jenis_kelamin == 'L' ? 'Laki-laki' : ($biodata->jenis_kelamin == 'P' ? 'Perempuan' : '-') }}
                </span>
            </div>

            <div>
                <span class="block text-sm font-bold opacity-70 mb-1">Agama</span>
                <span class="block px-3 py-2 bg-base-100 rounded-md border border-base-300">{{ $biodata->agama }}</span>
            </div>

            <div>
                <span class="block text-sm font-bold opacity-70 mb-1">Tinggi (cm)</span>
                <span class="block px-3 py-2 bg-base-100 rounded-md border border-base-300">{{ $biodata->tinggi }}</span>
            </div>

            <div>
                <span class="block text-sm font-bold opacity-70 mb-1">Berat (kg)</span>
                <span class="block px-3 py-2 bg-base-100 rounded-md border border-base-300">{{ $biodata->berat }}</span>
            </div>

            <div>
                <span class="block text-sm font-bold opacity-70 mb-1">Golongan Darah</span>
                <span class="block px-3 py-2 bg-base-100 rounded-md border border-base-300">{{ $biodata->gol_darah }}</span>
            </div>

            <div>
                <span class="block text-sm font-bold opacity-70 mb-1">Status Kawin</span>
                <span class="block px-3 py-2 bg-base-100 rounded-md border border-base-300">{{ $biodata->status_kawin }}</span>
            </div>

            <div>
                <span class="block text-sm font-bold opacity-70 mb-1">Hobby</span>
                <span class="block px-3 py-2 bg-base-100 rounded-md border border-base-300">{{ $biodata->hobby }}</span>
            </div>

            <div>
                <span class="block text-sm font-bold opacity-70 mb-1">Warganegara</span>
                <span class="block px-3 py-2 bg-base-100 rounded-md border border-base-300">{{ $biodata->warganegara }}</span>
            </div>

            <!-- Kontak & Alamat -->
            <div class="md:col-span-2 mt-4">
                <h3 class="font-bold text-lg text-primary">Kontak & Alamat</h3>
            </div>

            <div class="md:col-span-2">
                <span class="block text-sm font-bold opacity-70 mb-1">Alamat Lengkap</span>
                <span class="block px-3 py-2 bg-base-100 rounded-md border border-base-300 min-h-[3rem]">{{ $biodata->alamat }}</span>
            </div>

            <div>
                <span class="block text-sm font-bold opacity-70 mb-1">Kecamatan</span>
                <span class="block px-3 py-2 bg-base-100 rounded-md border border-base-300">{{ $biodata->kecamatan }}</span>
            </div>

            <div>
                <span class="block text-sm font-bold opacity-70 mb-1">Kelurahan</span>
                <span class="block px-3 py-2 bg-base-100 rounded-md border border-base-300">{{ $biodata->kelurahan }}</span>
            </div>

            <div>
                <span class="block text-sm font-bold opacity-70 mb-1">Kota</span>
                <span class="block px-3 py-2 bg-base-100 rounded-md border border-base-300">{{ $biodata->kota }}</span>
            </div>

            <div>
                <span class="block text-sm font-bold opacity-70 mb-1">Kode Pos</span>
                <span class="block px-3 py-2 bg-base-100 rounded-md border border-base-300">{{ $biodata->kodepos }}</span>
            </div>

            <div>
                <span class="block text-sm font-bold opacity-70 mb-1">No. Telp</span>
                <span class="block px-3 py-2 bg-base-100 rounded-md border border-base-300">{{ $biodata->no_telp }}</span>
            </div>

            <div>
                <span class="block text-sm font-bold opacity-70 mb-1">Handphone</span>
                <span class="block px-3 py-2 bg-base-100 rounded-md border border-base-300">{{ $biodata->handphone }}</span>
            </div>

            <div class="md:col-span-2">
                <span class="block text-sm font-bold opacity-70 mb-1">Email</span>
                <span class="block px-3 py-2 bg-base-100 rounded-md border border-base-300">{{ $biodata->email }}</span>
            </div>

            <!-- Pendidikan & Latar Belakang -->
            <div class="md:col-span-2 mt-4">
                <h3 class="font-bold text-lg text-primary">Pendidikan & Akademik</h3>
            </div>

            <div>
                <span class="block text-sm font-bold opacity-70 mb-1">NISN</span>
                <span class="block px-3 py-2 bg-base-100 rounded-md border border-base-300">{{ $biodata->nisn }}</span>
            </div>

            <div>
                <span class="block text-sm font-bold opacity-70 mb-1">Asal SMU</span>
                <span class="block px-3 py-2 bg-base-100 rounded-md border border-base-300">{{ $biodata->asal_smu }}</span>
            </div>

            <div>
                <span class="block text-sm font-bold opacity-70 mb-1">Lulus SMU</span>
                <span class="block px-3 py-2 bg-base-100 rounded-md border border-base-300">{{ $biodata->lulus_smu }}</span>
            </div>



            <div>
                <span class="block text-sm font-bold opacity-70 mb-1">Status Pendidikan</span>
                <span class="block px-3 py-2 bg-base-100 rounded-md border border-base-300">{{ $biodata->status_pendidikan }}</span>
            </div>

            <div>
                <span class="block text-sm font-bold opacity-70 mb-1">PATAUM</span>
                <span class="block px-3 py-2 bg-base-100 rounded-md border border-base-300">{{ $biodata->pataum }}</span>
            </div>

            <!-- Informasi Keluarga -->
            <div class="md:col-span-2 mt-4">
                <h3 class="font-bold text-lg text-primary">Informasi Keluarga</h3>
            </div>

            <div>
                <span class="block text-sm font-bold opacity-70 mb-1">Anak Ke-</span>
                <span class="block px-3 py-2 bg-base-100 rounded-md border border-base-300">{{ $biodata->anak_ke }}</span>
            </div>

            <div>
                <span class="block text-sm font-bold opacity-70 mb-1">Jumlah Saudara</span>
                <span class="block px-3 py-2 bg-base-100 rounded-md border border-base-300">{{ $biodata->jml_saudara }}</span>
            </div>

            <div>
                <span class="block text-sm font-bold opacity-70 mb-1">Jumlah Saudara Tanggungan</span>
                <span class="block px-3 py-2 bg-base-100 rounded-md border border-base-300">{{ $biodata->jml_saudara_tanggungan }}</span>
            </div>

            <div>
                <span class="block text-sm font-bold opacity-70 mb-1">Sumber Biaya</span>
                <span class="block px-3 py-2 bg-base-100 rounded-md border border-base-300">{{ $biodata->sumber_biaya }}</span>
            </div>

            <div>
                <span class="block text-sm font-bold opacity-70 mb-1">Jenis Rumah</span>
                <span class="block px-3 py-2 bg-base-100 rounded-md border border-base-300">{{ $biodata->jenis_rmh }}</span>
            </div>

            <div>
                <span class="block text-sm font-bold opacity-70 mb-1">Transportasi</span>
                <span class="block px-3 py-2 bg-base-100 rounded-md border border-base-300">{{ $biodata->transportasi }}</span>
            </div>

            <!-- Data Ayah -->
            <div class="md:col-span-2 mt-4">
                <h3 class="font-bold text-lg text-primary border-b border-base-300 pb-1">Data Ayah</h3>
            </div>
            
            <div><span class="block text-sm font-bold opacity-70 mb-1">Nama</span><span class="block px-3 py-2 bg-base-100 rounded-md border border-base-300">{{ $biodata->nama_ayah }}</span></div>
            <div><span class="block text-sm font-bold opacity-70 mb-1">No Telp / HP</span><span class="block px-3 py-2 bg-base-100 rounded-md border border-base-300">{{ $biodata->no_telp_ayah }} / {{ $biodata->handphone_ayah }}</span></div>
            <div class="md:col-span-2"><span class="block text-sm font-bold opacity-70 mb-1">Alamat</span><span class="block px-3 py-2 bg-base-100 rounded-md border border-base-300">{{ $biodata->alamat_ayah }}, {{ $biodata->kota_ayah }} ({{ $biodata->kodepos_ayah }})</span></div>
            <div><span class="block text-sm font-bold opacity-70 mb-1">Agama</span><span class="block px-3 py-2 bg-base-100 rounded-md border border-base-300">{{ $biodata->agama_ayah }}</span></div>
            <div><span class="block text-sm font-bold opacity-70 mb-1">Warganegara</span><span class="block px-3 py-2 bg-base-100 rounded-md border border-base-300">{{ $biodata->warganegara_ayah }}</span></div>
            <div><span class="block text-sm font-bold opacity-70 mb-1">Pendidikan</span><span class="block px-3 py-2 bg-base-100 rounded-md border border-base-300">{{ $biodata->pendidikan_ayah }}</span></div>
            <div><span class="block text-sm font-bold opacity-70 mb-1">Pekerjaan</span><span class="block px-3 py-2 bg-base-100 rounded-md border border-base-300">{{ $biodata->pekerjaan_ayah }}</span></div>
            <div><span class="block text-sm font-bold opacity-70 mb-1">Kebutuhan Ayah</span><span class="block px-3 py-2 bg-base-100 rounded-md border border-base-300">{{ $biodata->kebutuhan_ayah }}</span></div>

            <!-- Data Ibu -->
            <div class="md:col-span-2 mt-4">
                <h3 class="font-bold text-lg text-primary border-b border-base-300 pb-1">Data Ibu</h3>
            </div>

            <div><span class="block text-sm font-bold opacity-70 mb-1">Nama</span><span class="block px-3 py-2 bg-base-100 rounded-md border border-base-300">{{ $biodata->nama_ibu }}</span></div>
            <div><span class="block text-sm font-bold opacity-70 mb-1">No Telp / HP</span><span class="block px-3 py-2 bg-base-100 rounded-md border border-base-300">{{ $biodata->no_telp_ibu }} / {{ $biodata->handphone_ibu }}</span></div>
            <div class="md:col-span-2"><span class="block text-sm font-bold opacity-70 mb-1">Alamat</span><span class="block px-3 py-2 bg-base-100 rounded-md border border-base-300">{{ $biodata->alamat_ibu }}, {{ $biodata->kota_ibu }} ({{ $biodata->kodepos_ibu }})</span></div>
            <div><span class="block text-sm font-bold opacity-70 mb-1">Agama</span><span class="block px-3 py-2 bg-base-100 rounded-md border border-base-300">{{ $biodata->agama_ibu }}</span></div>
            <div><span class="block text-sm font-bold opacity-70 mb-1">Warganegara</span><span class="block px-3 py-2 bg-base-100 rounded-md border border-base-300">{{ $biodata->warganegara_ibu }}</span></div>
            <div><span class="block text-sm font-bold opacity-70 mb-1">Pendidikan</span><span class="block px-3 py-2 bg-base-100 rounded-md border border-base-300">{{ $biodata->pendidikan_ibu }}</span></div>
            <div><span class="block text-sm font-bold opacity-70 mb-1">Pekerjaan</span><span class="block px-3 py-2 bg-base-100 rounded-md border border-base-300">{{ $biodata->pekerjaan_ibu }}</span></div>
            <div><span class="block text-sm font-bold opacity-70 mb-1">Kebutuhan Ibu</span><span class="block px-3 py-2 bg-base-100 rounded-md border border-base-300">{{ $biodata->kebutuhan_ibu }}</span></div>

            <!-- Data Wali -->
            <div class="md:col-span-2 mt-4">
                <h3 class="font-bold text-lg text-primary border-b border-base-300 pb-1">Data Wali</h3>
            </div>

            <div><span class="block text-sm font-bold opacity-70 mb-1">Nama</span><span class="block px-3 py-2 bg-base-100 rounded-md border border-base-300">{{ $biodata->nama_wali ?: '-' }}</span></div>
            <div><span class="block text-sm font-bold opacity-70 mb-1">No Telp / HP</span><span class="block px-3 py-2 bg-base-100 rounded-md border border-base-300">{{ $biodata->no_telp_wali ?: '-' }} / {{ $biodata->handphone_wali ?: '-' }}</span></div>
            <div class="md:col-span-2"><span class="block text-sm font-bold opacity-70 mb-1">Alamat</span><span class="block px-3 py-2 bg-base-100 rounded-md border border-base-300">{{ $biodata->alamat_wali ?: '-' }}, {{ $biodata->kota_wali ?: '-' }} ({{ $biodata->kodepos_wali ?: '-' }})</span></div>
            <div><span class="block text-sm font-bold opacity-70 mb-1">Agama</span><span class="block px-3 py-2 bg-base-100 rounded-md border border-base-300">{{ $biodata->agama_wali ?: '-' }}</span></div>
            <div><span class="block text-sm font-bold opacity-70 mb-1">Warganegara</span><span class="block px-3 py-2 bg-base-100 rounded-md border border-base-300">{{ $biodata->warganegara_wali ?: '-' }}</span></div>
            <div><span class="block text-sm font-bold opacity-70 mb-1">Pendidikan</span><span class="block px-3 py-2 bg-base-100 rounded-md border border-base-300">{{ $biodata->pendidikan_wali ?: '-' }}</span></div>
            <div><span class="block text-sm font-bold opacity-70 mb-1">Pekerjaan</span><span class="block px-3 py-2 bg-base-100 rounded-md border border-base-300">{{ $biodata->pekerjaan_wali ?: '-' }}</span></div>

            <!-- Informasi Tambahan -->
            <div class="md:col-span-2 mt-4">
                <h3 class="font-bold text-lg text-primary">Informasi Tambahan</h3>
            </div>

            <div>
                <span class="block text-sm font-bold opacity-70 mb-1">Special Need</span>
                <span class="block px-3 py-2 bg-base-100 rounded-md border border-base-300">{{ $biodata->special_need }}</span>
            </div>

            <div>
                <span class="block text-sm font-bold opacity-70 mb-1">KPS</span>
                <span class="block px-3 py-2 bg-base-100 rounded-md border border-base-300">{{ $biodata->kps }}</span>
            </div>

            <div class="md:col-span-2">
                <span class="block text-sm font-bold opacity-70 mb-1">Last Update</span>
                <span class="block px-3 py-2 bg-base-100 rounded-md border border-base-300">{{ $biodata->last_update ? \Carbon\Carbon::parse($biodata->last_update)->format('d F Y') : '-' }}</span>
            </div>
            
        </div>
    </div>
</x-layout>