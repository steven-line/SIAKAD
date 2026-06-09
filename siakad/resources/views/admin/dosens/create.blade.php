<x-layout>
    <a class="join-item btn btn-primary mb-4" href="/admin/kelola-dosen">⮜ Previous page</a>
    
    <form action="/admin/kelola-dosen" method="POST">
        @csrf
        <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-full max-w-sm border p-6 mx-auto">
            <legend class="fieldset-legend font-bold text-lg">Tambah Dosen Baru</legend>

            <label class="label font-bold" for="nim_dosen">NIM DOSEN</label>
            <input type="text" class="input w-full" name="nim_dosen" placeholder="Masukkan NIM Dosen" required />
            <x-forms.error name='nim_dosen'/>

            <label class="label font-bold mt-2" for="nip">NIP</label>
            <input type="text" class="input w-full" name="nip" placeholder="Masukkan NIP" required />
            <x-forms.error name='nip'/>
            
            <label class="label font-bold mt-2" for="nama">Nama</label>
            <input type="text" class="input w-full" name="nama" placeholder="Masukkan Nama Lengkap" required />
            <x-forms.error name='nama'/>

            <label class="label font-bold mt-2" for="user_id">Akun User (Log In)</label>
            <select class="select select-bordered w-full" name="user_id" required>
                <option disabled selected>Select user</option>
                @foreach ($users as $user)  
                    <option value="{{ $user->username }}">{{ $user->username }}</option>  
                @endforeach
            </select>
            <x-forms.error name='user_id'/>

            <label class="label font-bold mt-2" for="prodi">Program Studi (Homebase)</label>
            <select class="select select-bordered w-full" name="prodi" required>
                <option disabled selected>Pilih Program Studi</option>
                @foreach ($prodis as $prodi)  
                    <option value="{{ $prodi->kode_prodi }}">{{ $prodi->nama_prodi }}</option>  
                @endforeach
            </select>
            <x-forms.error name='prodi'/>

            <label class="label font-bold mt-2" for="jabatan_struktural">Jabatan Struktural</label>
            <input type="text" class="input w-full" name="jabatan_struktural" placeholder="Masukkan jabatan struktural" required />
            <x-forms.error name='jabatan_struktural'/>

            <button class="btn btn-primary mt-6 w-full">Buat Data Dosen</button>
        </fieldset>
    </form>
</x-layout>