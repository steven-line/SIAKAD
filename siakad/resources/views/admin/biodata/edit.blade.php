
<x-layout>
    <a class="join-item btn btn-primary mb-4" href="{{ route('biodata.index') }}">
        ⮜ Previous page
    </a>
@if($errors->any())
    {!! implode('', $errors->all('<div>:message</div>')) !!}
@endif

    <form action="{{ route('biodata.update', $biodata->nrp) }}" method="POST">
        @csrf
        @method('PATCH')

        <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-full border p-6 mx-auto max-w-4xl">
            <legend class="fieldset-legend font-bold text-lg">Edit Biodata</legend>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <label class="label font-bold" for="nrp">NRP</label>
                    <select class="select select-bordered w-full" name="nrp" required>
                        <option disabled>Pilih NRP</option>
                        @foreach ($mahasiswas as $mhs)
                            <option value="{{ $mhs->nrp }}" {{ old('nrp', $biodata->nrp) == $mhs->nrp ? 'selected' : '' }}>
                                {{ $mhs->nrp }}
                            </option>
                        @endforeach
                    </select>
                    <x-forms.error name="nrp" />
                </div>

                <div>
                    <label class="label font-bold" for="nama">Nama</label>
                    <input type="text" maxlength="50" class="input w-full" name="nama" value="{{ old('nama', $biodata->nama) }}" placeholder="Masukkan Nama Lengkap" required />
                    <x-forms.error name="nama" />
                </div>

                <div>
                    <label class="label font-bold" for="nik">NIK</label>
                    <input type="text" maxlength="16" class="input w-full" name="nik" value="{{ old('nik', $biodata->nik) }}" placeholder="Masukkan NIK" required />
                    <x-forms.error name="nik" />
                </div>

                <div>
                    <label class="label font-bold" for="tempat_lahir">Tempat Lahir</label>
                    <input type="text" maxlength="25" class="input w-full" name="tempat_lahir" value="{{ old('tempat_lahir', $biodata->tempat_lahir) }}" placeholder="Masukkan Tempat Lahir" />
                    <x-forms.error name="tempat_lahir" />
                </div>

                <div>
                    <label class="label font-bold" for="tanggal_lahir">Tanggal Lahir</label>
                    <input type="date" class="input w-full" name="tanggal_lahir" value="{{ old('tanggal_lahir', $biodata->tanggal_lahir) }}" />
                    <x-forms.error name="tanggal_lahir" />
                </div>
                  <div>
                 
                </div>
                  <div>
                    <label class="label font-bold" for="jenis_kelamin">Jenis Kelamin</label>
                    <select class="select select-bordered w-full" name="jenis_kelamin" required>
                        <option disabled>Pilih Jenis Kelamin</option>
                        <option value="L" {{ old('jenis_kelamin', $biodata->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin', $biodata->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    <x-forms.error name="jenis_kelamin" />
                </div>

                <div>
                    <label class="label font-bold" for="tinggi">Tinggi</label>
                    <input type="number" maxlength="11" oninput="this.value=this.value.slice(0,this.maxLength)" class="input w-full" name="tinggi" value="{{ old('tinggi', $biodata->tinggi) }}" placeholder="Masukkan Tinggi Badan" required />
                    <x-forms.error name="tinggi" />
                </div>

                <div>
                    <label class="label font-bold" for="berat">Berat</label>
                    <input type="number" maxlength="11" oninput="this.value=this.value.slice(0,this.maxLength)" class="input w-full" name="berat" value="{{ old('berat', $biodata->berat) }}" placeholder="Masukkan Berat Badan" required />
                    <x-forms.error name="berat" />
                </div>

                <div class="md:col-span-2">
                    <label class="label font-bold" for="alamat">Alamat</label>
                    <textarea class="textarea textarea-bordered w-full" name="alamat" maxlength="100" placeholder="Masukkan Alamat" required>{{ old('alamat', $biodata->alamat) }}</textarea>
                    <x-forms.error name="alamat" />
                </div>

                <div>
                    <label class="label font-bold" for="kecamatan">Kecamatan</label>
                    <input type="text" maxlength="20" class="input w-full" name="kecamatan" value="{{ old('kecamatan', $biodata->kecamatan) }}" placeholder="Masukkan Kecamatan" required />
                    <x-forms.error name="kecamatan" />
                </div>

                <div>
                    <label class="label font-bold" for="kelurahan">Kelurahan</label>
                    <input type="text" maxlength="50" class="input w-full" name="kelurahan" value="{{ old('kelurahan', $biodata->kelurahan) }}" placeholder="Masukkan Kelurahan" required />
                    <x-forms.error name="kelurahan" />
                </div>

                <div>
                    <label class="label font-bold" for="kota">Kota</label>
                    <input type="text" maxlength="25" class="input w-full" name="kota" value="{{ old('kota', $biodata->kota) }}" placeholder="Masukkan Kota" required />
                    <x-forms.error name="kota" />
                </div>

                <div>
                    <label class="label font-bold" for="kodepos">Kode Pos</label>
                    <input type="text" maxlength="5" class="input w-full" name="kodepos" value="{{ old('kodepos', $biodata->kodepos) }}" placeholder="Masukkan Kode Pos" required />
                    <x-forms.error name="kodepos" />
                </div>

                <div>
                    <label class="label font-bold" for="no_telp">No Telp</label>
                    <input type="text" maxlength="13" class="input w-full" name="no_telp" value="{{ old('no_telp', $biodata->no_telp) }}" placeholder="Masukkan No Telp" required />
                    <x-forms.error name="no_telp" />
                </div>

                <div>
                    <label class="label font-bold" for="handphone">Handphone</label>
                    <input type="text" maxlength="13" class="input w-full" name="handphone" value="{{ old('handphone', $biodata->handphone) }}" placeholder="Masukkan Handphone" required />
                    <x-forms.error name="handphone" />
                </div>

                <div>
                    <label class="label font-bold" for="hobby">Hobby</label>
                    <input type="text" maxlength="30" class="input w-full" name="hobby" value="{{ old('hobby', $biodata->hobby) }}" placeholder="Masukkan Hobby" required />
                    <x-forms.error name="hobby" />
                </div>

                <div>
                    <label class="label font-bold" for="agama">Agama</label>
                    <input type="text" maxlength="15" class="input w-full" name="agama" value="{{ old('agama', $biodata->agama) }}" placeholder="Masukkan Agama" required />
                    <x-forms.error name="agama" />
                </div>

                <div>
                    <label class="label font-bold" for="warganegara">Warganegara</label>
                    <input type="text" maxlength="15" class="input w-full" name="warganegara" value="{{ old('warganegara', $biodata->warganegara) }}" placeholder="Masukkan Warganegara" required />
                    <x-forms.error name="warganegara" />
                </div>

                <div>
                    <label class="label font-bold" for="status_kawin">Status Kawin</label>
                    <input type="text" maxlength="15" class="input w-full" name="status_kawin" value="{{ old('status_kawin', $biodata->status_kawin) }}" placeholder="Masukkan Status Kawin" required />
                    <x-forms.error name="status_kawin" />
                </div>

                <div>
                    <label class="label font-bold" for="gol_darah">Golongan Darah</label>
                    <input type="text" maxlength="10" class="input w-full" name="gol_darah" value="{{ old('gol_darah', $biodata->gol_darah) }}" placeholder="Masukkan Golongan Darah" required />
                    <x-forms.error name="gol_darah" />
                </div>

                <div>
                    <label class="label font-bold" for="anak_ke">Anak Ke</label>
                    <input type="number" maxlength="11" oninput="this.value=this.value.slice(0,this.maxLength)" class="input w-full" name="anak_ke" value="{{ old('anak_ke', $biodata->anak_ke) }}" placeholder="Masukkan Anak Ke" required />
                    <x-forms.error name="anak_ke" />
                </div>

                <div>
                    <label class="label font-bold" for="jml_saudara">Jumlah Saudara</label>
                    <input type="number" maxlength="11" oninput="this.value=this.value.slice(0,this.maxLength)" class="input w-full" name="jml_saudara" value="{{ old('jml_saudara', $biodata->jml_saudara) }}" placeholder="Masukkan Jumlah Saudara" required />
                    <x-forms.error name="jml_saudara" />
                </div>

                <div>
                    <label class="label font-bold" for="jml_saudara_tanggungan">Jumlah Saudara Tanggungan</label>
                    <input type="number" maxlength="11" oninput="this.value=this.value.slice(0,this.maxLength)" class="input w-full" name="jml_saudara_tanggungan" value="{{ old('jml_saudara_tanggungan', $biodata->jml_saudara_tanggungan) }}" placeholder="Masukkan Jumlah Saudara Tanggungan" required />
                    <x-forms.error name="jml_saudara_tanggungan" />
                </div>

                <div>
                    <label class="label font-bold" for="sumber_biaya">Sumber Biaya</label>
                    <input type="text" maxlength="25" class="input w-full" name="sumber_biaya" value="{{ old('sumber_biaya', $biodata->sumber_biaya) }}" placeholder="Masukkan Sumber Biaya" required />
                    <x-forms.error name="sumber_biaya" />
                </div>

                <div>
                    <label class="label font-bold" for="jenis_rmh">Jenis Rumah</label>
                    <input type="text" maxlength="20" class="input w-full" name="jenis_rmh" value="{{ old('jenis_rmh', $biodata->jenis_rmh) }}" placeholder="Masukkan Jenis Rumah" required />
                    <x-forms.error name="jenis_rmh" />
                </div>

                <div>
                    <label class="label font-bold" for="asal_smu">Asal SMU</label>
                    <input type="text" maxlength="50" class="input w-full" name="asal_smu" value="{{ old('asal_smu', $biodata->asal_smu) }}" placeholder="Masukkan Asal SMU" required />
                    <x-forms.error name="asal_smu" />
                </div>

                <div>
                    <label class="label font-bold" for="lulus_smu">Lulus SMU</label>
                    <input type="text" maxlength="4" class="input w-full" name="lulus_smu" value="{{ old('lulus_smu', $biodata->lulus_smu) }}" placeholder="Contoh: 2024" required />
                    <x-forms.error name="lulus_smu" />
                </div>

                <div>
                    <label class="label font-bold" for="transportasi">Transportasi</label>
                    <input type="text" maxlength="25" class="input w-full" name="transportasi" value="{{ old('transportasi', $biodata->transportasi) }}" placeholder="Masukkan Transportasi" required />
                    <x-forms.error name="transportasi" />
                </div>


                <div>
                    <label class="label font-bold" for="nama_ayah">Nama Ayah</label>
                    <input type="text" maxlength="50" class="input w-full" name="nama_ayah" value="{{ old('nama_ayah', $biodata->nama_ayah) }}" placeholder="Masukkan Nama Ayah" required />
                    <x-forms.error name="nama_ayah" />
                </div>

                <div>
                    <label class="label font-bold" for="alamat_ayah">Alamat Ayah</label>
                    <input type="text" maxlength="100" class="input w-full" name="alamat_ayah" value="{{ old('alamat_ayah', $biodata->alamat_ayah) }}" placeholder="Masukkan Alamat Ayah" required />
                    <x-forms.error name="alamat_ayah" />
                </div>

                <div>
                    <label class="label font-bold" for="no_telp_ayah">No Telp Ayah</label>
                    <input type="text" maxlength="13" class="input w-full" name="no_telp_ayah" value="{{ old('no_telp_ayah', $biodata->no_telp_ayah) }}" placeholder="Masukkan No Telp Ayah" required />
                    <x-forms.error name="no_telp_ayah" />
                </div>

                <div>
                    <label class="label font-bold" for="kota_ayah">Kota Ayah</label>
                    <input type="text" maxlength="25" class="input w-full" name="kota_ayah" value="{{ old('kota_ayah', $biodata->kota_ayah) }}" placeholder="Masukkan Kota Ayah" required />
                    <x-forms.error name="kota_ayah" />
                </div>

                <div>
                    <label class="label font-bold" for="kodepos_ayah">Kode Pos Ayah</label>
                    <input type="text" maxlength="5" class="input w-full" name="kodepos_ayah" value="{{ old('kodepos_ayah', $biodata->kodepos_ayah) }}" placeholder="Masukkan Kode Pos Ayah" required />
                    <x-forms.error name="kodepos_ayah" />
                </div>

                <div>
                    <label class="label font-bold" for="handphone_ayah">Handphone Ayah</label>
                    <input type="text" maxlength="12" class="input w-full" name="handphone_ayah" value="{{ old('handphone_ayah', $biodata->handphone_ayah) }}" placeholder="Masukkan Handphone Ayah" required />
                    <x-forms.error name="handphone_ayah" />
                </div>

                <div>
                    <label class="label font-bold" for="agama_ayah">Agama Ayah</label>
                    <input type="text" maxlength="15" class="input w-full" name="agama_ayah" value="{{ old('agama_ayah', $biodata->agama_ayah) }}" placeholder="Masukkan Agama Ayah" required />
                    <x-forms.error name="agama_ayah" />
                </div>

                <div>
                    <label class="label font-bold" for="pekerjaan_ayah">Pekerjaan Ayah</label>
                    <input type="text" maxlength="50" class="input w-full" name="pekerjaan_ayah" value="{{ old('pekerjaan_ayah', $biodata->pekerjaan_ayah) }}" placeholder="Masukkan Pekerjaan Ayah" required />
                    <x-forms.error name="pekerjaan_ayah" />
                </div>

                <div>
                    <label class="label font-bold" for="pendidikan_ayah">Pendidikan Ayah</label>
                    <input type="text" maxlength="25" class="input w-full" name="pendidikan_ayah" value="{{ old('pendidikan_ayah', $biodata->pendidikan_ayah) }}" placeholder="Masukkan Pendidikan Ayah" required />
                    <x-forms.error name="pendidikan_ayah" />
                </div>

                <div>
                    <label class="label font-bold" for="warganegara_ayah">Warganegara Ayah</label>
                    <input type="text" maxlength="20" class="input w-full" name="warganegara_ayah" value="{{ old('warganegara_ayah', $biodata->warganegara_ayah) }}" placeholder="Masukkan Warganegara Ayah" required />
                    <x-forms.error name="warganegara_ayah" />
                </div>

                <div>
                    <label class="label font-bold" for="nama_ibu">Nama Ibu</label>
                    <input type="text" maxlength="50" class="input w-full" name="nama_ibu" value="{{ old('nama_ibu', $biodata->nama_ibu) }}" placeholder="Masukkan Nama Ibu" required />
                    <x-forms.error name="nama_ibu" />
                </div>

                <div>
                    <label class="label font-bold" for="alamat_ibu">Alamat Ibu</label>
                    <input type="text" maxlength="100" class="input w-full" name="alamat_ibu" value="{{ old('alamat_ibu', $biodata->alamat_ibu) }}" placeholder="Masukkan Alamat Ibu" required />
                    <x-forms.error name="alamat_ibu" />
                </div>

                <div>
                    <label class="label font-bold" for="kota_ibu">Kota Ibu</label>
                    <input type="text" maxlength="25" class="input w-full" name="kota_ibu" value="{{ old('kota_ibu', $biodata->kota_ibu) }}" placeholder="Masukkan Kota Ibu" required />
                    <x-forms.error name="kota_ibu" />
                </div>

                <div>
                    <label class="label font-bold" for="kodepos_ibu">Kode Pos Ibu</label>
                    <input type="text" maxlength="5" class="input w-full" name="kodepos_ibu" value="{{ old('kodepos_ibu', $biodata->kodepos_ibu) }}" placeholder="Masukkan Kode Pos Ibu" required />
                    <x-forms.error name="kodepos_ibu" />
                </div>

                <div>
                    <label class="label font-bold" for="no_telp_ibu">No Telp Ibu</label>
                    <input type="text" maxlength="13" class="input w-full" name="no_telp_ibu" value="{{ old('no_telp_ibu', $biodata->no_telp_ibu) }}" placeholder="Masukkan No Telp Ibu" required />
                    <x-forms.error name="no_telp_ibu" />
                </div>

                <div>
                    <label class="label font-bold" for="handphone_ibu">Handphone Ibu</label>
                    <input type="text" maxlength="12" class="input w-full" name="handphone_ibu" value="{{ old('handphone_ibu', $biodata->handphone_ibu) }}" placeholder="Masukkan Handphone Ibu" required />
                    <x-forms.error name="handphone_ibu" />
                </div>

                <div>
                    <label class="label font-bold" for="agama_ibu">Agama Ibu</label>
                    <input type="text" maxlength="15" class="input w-full" name="agama_ibu" value="{{ old('agama_ibu', $biodata->agama_ibu) }}" placeholder="Masukkan Agama Ibu" required />
                    <x-forms.error name="agama_ibu" />
                </div>

                <div>
                    <label class="label font-bold" for="pekerjaan_ibu">Pekerjaan Ibu</label>
                    <input type="text" maxlength="50" class="input w-full" name="pekerjaan_ibu" value="{{ old('pekerjaan_ibu', $biodata->pekerjaan_ibu) }}" placeholder="Masukkan Pekerjaan Ibu" required />
                    <x-forms.error name="pekerjaan_ibu" />
                </div>

                <div>
                    <label class="label font-bold" for="pendidikan_ibu">Pendidikan Ibu</label>
                    <input type="text" maxlength="25" class="input w-full" name="pendidikan_ibu" value="{{ old('pendidikan_ibu', $biodata->pendidikan_ibu) }}" placeholder="Masukkan Pendidikan Ibu" required />
                    <x-forms.error name="pendidikan_ibu" />
                </div>

                <div>
                    <label class="label font-bold" for="warganegara_ibu">Warganegara Ibu</label>
                    <input type="text" maxlength="20" class="input w-full" name="warganegara_ibu" value="{{ old('warganegara_ibu', $biodata->warganegara_ibu) }}" placeholder="Masukkan Warganegara Ibu" required />
                    <x-forms.error name="warganegara_ibu" />
                </div>

                <div>
                    <label class="label font-bold" for="nama_wali">Nama Wali</label>
                    <input type="text" maxlength="50" class="input w-full" name="nama_wali" value="{{ old('nama_wali', $biodata->nama_wali) }}" placeholder="Masukkan Nama Wali" required />
                    <x-forms.error name="nama_wali" />
                </div>

                <div>
                    <label class="label font-bold" for="alamat_wali">Alamat Wali</label>
                    <input type="text" maxlength="100" class="input w-full" name="alamat_wali" value="{{ old('alamat_wali', $biodata->alamat_wali) }}" placeholder="Masukkan Alamat Wali" required />
                    <x-forms.error name="alamat_wali" />
                </div>

                <div>
                    <label class="label font-bold" for="kota_wali">Kota Wali</label>
                    <input type="text" maxlength="25" class="input w-full" name="kota_wali" value="{{ old('kota_wali', $biodata->kota_wali) }}" placeholder="Masukkan Kota Wali" required />
                    <x-forms.error name="kota_wali" />
                </div>

                <div>
                    <label class="label font-bold" for="kodepos_wali">Kode Pos Wali</label>
                    <input type="text" maxlength="5" class="input w-full" name="kodepos_wali" value="{{ old('kodepos_wali', $biodata->kodepos_wali) }}" placeholder="Masukkan Kode Pos Wali" required />
                    <x-forms.error name="kodepos_wali" />
                </div>

                <div>
                    <label class="label font-bold" for="no_telp_wali">No Telp Wali</label>
                    <input type="text" maxlength="13" class="input w-full" name="no_telp_wali" value="{{ old('no_telp_wali', $biodata->no_telp_wali) }}" placeholder="Masukkan No Telp Wali" required />
                    <x-forms.error name="no_telp_wali" />
                </div>

                <div>
                    <label class="label font-bold" for="handphone_wali">Handphone Wali</label>
                    <input type="text" maxlength="12" class="input w-full" name="handphone_wali" value="{{ old('handphone_wali', $biodata->handphone_wali) }}" placeholder="Masukkan Handphone Wali" required />
                    <x-forms.error name="handphone_wali" />
                </div>

                <div>
                    <label class="label font-bold" for="agama_wali">Agama Wali</label>
                    <input type="text" maxlength="15" class="input w-full" name="agama_wali" value="{{ old('agama_wali', $biodata->agama_wali) }}" placeholder="Masukkan Agama Wali" required />
                    <x-forms.error name="agama_wali" />
                </div>

                <div>
                    <label class="label font-bold" for="pekerjaan_wali">Pekerjaan Wali</label>
                    <input type="text" maxlength="50" class="input w-full" name="pekerjaan_wali" value="{{ old('pekerjaan_wali', $biodata->pekerjaan_wali) }}" placeholder="Masukkan Pekerjaan Wali" required />
                    <x-forms.error name="pekerjaan_wali" />
                </div>

                <div>
                    <label class="label font-bold" for="pendidikan_wali">Pendidikan Wali</label>
                    <input type="text" maxlength="25" class="input w-full" name="pendidikan_wali" value="{{ old('pendidikan_wali', $biodata->pendidikan_wali) }}" placeholder="Masukkan Pendidikan Wali" required />
                    <x-forms.error name="pendidikan_wali" />
                </div>

                <div>
                    <label class="label font-bold" for="warganegara_wali">Warganegara Wali</label>
                    <input type="text" maxlength="20" class="input w-full" name="warganegara_wali" value="{{ old('warganegara_wali', $biodata->warganegara_wali) }}" placeholder="Masukkan Warganegara Wali" required />
                    <x-forms.error name="warganegara_wali" />
                </div>

                <div>
                    <label class="label font-bold" for="special_need">Special Need</label>
                    <input type="text" maxlength="4" class="input w-full" name="special_need" value="{{ old('special_need', $biodata->special_need) }}" placeholder="Contoh: A001" required />
                    <x-forms.error name="special_need" />
                </div>

                <div>
                    <label class="label font-bold" for="kps">KPS</label>
                    <input type="number" maxlength="11" oninput="this.value = this.value.slice(0, this.maxLength)" class="input w-full" name="kps" value="{{ old('kps', $biodata->kps) }}" placeholder="Masukkan KPS" required />
                    <x-forms.error name="kps" />
                </div>

                <div>
                    <label class="label font-bold" for="status_pendidikan">Status Pendidikan</label>
                    <input type="text" maxlength="1" class="input w-full" name="status_pendidikan" value="{{ old('status_pendidikan', $biodata->status_pendidikan) }}" placeholder="Contoh: 1" required />
                    <x-forms.error name="status_pendidikan" />
                </div>
                <div>
                    <label class="label font-bold" for="kebutuhan_ayah">Kebutuhan Ayah</label>
                    <input type="text" maxlength="4" class="input w-full" name="kebutuhan_ayah" value="{{ old('kebutuhan_ayah', $biodata->kebutuhan_ayah) }}" placeholder="Contoh: A001" required />
                    <x-forms.error name="kebutuhan_ayah" />
                </div>

                <div>
                    <label class="label font-bold" for="kebutuhan_ibu">Kebutuhan Ibu</label>
                    <input type="text" maxlength="4" class="input w-full" name="kebutuhan_ibu" value="{{ old('kebutuhan_ibu', $biodata->kebutuhan_ibu) }}" placeholder="Contoh: B001" required />
                    <x-forms.error name="kebutuhan_ibu" />
                </div>

                <div>
                    <label class="label font-bold" for="last_update">Last Update</label>
                    <input type="date" class="input w-full" name="last_update" value="{{ old('last_update', $biodata->last_update) ?? date('Y-m-d') }}" required />
                    <x-forms.error name="last_update" />
                </div>

               

                <div>
                    <label class="label font-bold" for="email">Email</label>
                    <input type="email" maxlength="100" class="input w-full" name="email" value="{{ old('email', $biodata->email) }}" placeholder="Masukkan Email" required />
                    <x-forms.error name="email" />
                </div>

                <div class="md:col-span-2">
                    <label class="label font-bold" for="nisn">NISN</label>
                    <input type="text" maxlength="25" class="input w-full" name="nisn" value="{{ old('nisn', $biodata->nisn) }}" placeholder="Masukkan NISN" required />
                    <x-forms.error name="nisn" />
                </div>
            </div>

            <button class="btn btn-primary mt-6 w-full">Update Biodata</button>
        </fieldset>
    </form>
</x-layout>