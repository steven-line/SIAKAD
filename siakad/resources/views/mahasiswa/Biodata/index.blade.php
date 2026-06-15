<x-layout title="Biodata Mahasiswa">
    <div class="container mx-auto p-4">
        <!-- Header -->
        <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mb-6 rounded shadow-sm">
            <p class="font-semibold">BERIKUT ADALAH DATA DIRI ANDA, JIKA ADA KENDALA SILAHKAN MENGHUBUNGI KAMI</p>
        </div>

        <!-- Tabel / Grid Data Diri -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-6">
                <!-- Baris 1 -->
                <div class="flex border-b pb-2">
                    <div class="w-1/3 font-semibold text-gray-700">NRP</div>
                    <div class="w-2/3 text-gray-900">: {{ $biodata->nrp }}</div>
                </div>
                <div class="flex border-b pb-2">
                    <div class="w-1/3 font-semibold text-gray-700">Nama</div>
                    <div class="w-2/3 text-gray-900">: {{ $biodata->nama }}</div>
                </div>

                <!-- Baris 2 -->
                <div class="flex border-b pb-2">
                    <div class="w-1/3 font-semibold text-gray-700">NIK KTP</div>
                    <div class="w-2/3 text-gray-900">: {{ $biodata->nik ?? '-' }}</div>
                </div>
                <div class="flex border-b pb-2">
                    <div class="w-1/3 font-semibold text-gray-700">JENIS KELAMIN</div>
                    <div class="w-2/3 text-gray-900">: {{ $biodata->jenis_kelamin ?? ($biodata->sex == 'L' ? 'LAKI-LAKI' : 'PEREMPUAN') }}</div>
                </div>

                <!-- Baris 3 -->
                <div class="flex border-b pb-2">
                    <div class="w-1/3 font-semibold text-gray-700">TEMPAT & TANGGAL LAHIR</div>
                    <div class="w-2/3 text-gray-900">: {{ $biodata->tempat_lahir ?? '-' }} / {{ $biodata->tanggal_lahir ?? '-' }}</div>
                </div>
                <div class="flex border-b pb-2">
                    <div class="w-1/3 font-semibold text-gray-700">ALAMAT</div>
                    <div class="w-2/3 text-gray-900">: {{ $biodata->alamat ?? '-' }}</div>
                </div>

                <!-- Baris 4 -->
                <div class="flex border-b pb-2">
                    <div class="w-1/3 font-semibold text-gray-700">KOTA</div>
                    <div class="w-2/3 text-gray-900">: {{ $biodata->kota ?? '-' }}</div>
                </div>
                <div class="flex border-b pb-2">
                    <div class="w-1/3 font-semibold text-gray-700">KODE POS</div>
                    <div class="w-2/3 text-gray-900">: {{ $biodata->kodepos ?? '-' }}</div>
                </div>

                <!-- Baris 5 -->
                <div class="flex border-b pb-2">
                    <div class="w-1/3 font-semibold text-gray-700">EMAIL</div>
                    <div class="w-2/3 text-gray-900">: {{ $biodata->email ?? '-' }}</div>
                </div>
                <div class="flex border-b pb-2">
                    <div class="w-1/3 font-semibold text-gray-700">AGAMA</div>
                    <div class="w-2/3 text-gray-900">: {{ $biodata->agama ?? '-' }}</div>
                </div>

                <!-- Baris 6 -->
                <div class="flex border-b pb-2">
                    <div class="w-1/3 font-semibold text-gray-700">TELPON</div>
                    <div class="w-2/3 text-gray-900">: {{ $biodata->no_telp ?? '-' }}</div>
                </div>
                <div class="flex border-b pb-2">
                    <div class="w-1/3 font-semibold text-gray-700">HANDPHONE</div>
                    <div class="w-2/3 text-gray-900">: {{ $biodata->handphone ?? '-' }}</div>
                </div>

                <!-- Baris 7 -->
                <div class="flex border-b pb-2"> 
                    <div class="w-1/3 font-semibold text-gray-700">Dosen Wali</div>
                    <div class="w-2/3 text-gray-900">: {{ $biodata->dosenwali_nama ?? '-' }}</div>
                </div>
            </div>
        </div>

        <!-- Footer / Tambahan (opsional) -->
        <div class="mt-6 text-center text-sm text-gray-500">
            <p>Jika ada data yang tidak sesuai, silakan hubungi bagian kemahasiswaan atau dosen wali Anda.</p>
        </div>
    </div>
</x-layout>