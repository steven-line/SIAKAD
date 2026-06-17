<x-layout>
    <a class="join-item btn btn-primary mb-4" href="{{ route('dosen.index') }}">
        ⮜ Previous page
    </a>

    <form action="{{ route('dosen.update', $dosen->nim_dosen) }}" method="POST">
        @csrf
        @method('PATCH')

        <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-full max-w-sm border p-6 mx-auto">
            <legend class="fieldset-legend font-bold text-lg">Edit Data Dosen</legend>

            <label class="label font-bold" for="nim_dosen">NIM DOSEN</label>
            <input type="text" class="input w-full" name="nim_dosen" value="{{ $dosen->nim_dosen }}" required />
            <x-forms.error name='nim_dosen'/>

            <label class="label font-bold mt-2" for="nip">NIP</label>
            <input type="text" class="input w-full" name="nip" value="{{ $dosen->nip }}" required />
            <x-forms.error name='nip'/>

            <label class="label font-bold mt-2" for="nama">Nama</label>
            <input type="text" class="input w-full" name="nama" value="{{ $dosen->nama }}" required />
            <x-forms.error name='nama'/>

            <label class="label font-bold mt-2" for="user_id">Akun User (Log In)</label>
            <select class="select select-bordered w-full" name="user_id" required>
                <option disabled>Select user</option>
                @foreach ($users as $user)
                    <option value="{{ $user->username }}" {{ $dosen->user_id == $user->username ? 'selected' : '' }}>
                        {{ $user->username }}
                    </option>
                @endforeach
            </select>
            <x-forms.error name='user_id'/>

            <label class="label font-bold mt-2" for="prodi">Program Studi (Homebase)</label>
            <select class="select select-bordered w-full" name="prodi" required>
                <option disabled>Pilih Program Studi</option>
                @foreach ($prodis as $prodi)
                    <option value="{{ $prodi->kode_prodi }}" {{ $dosen->prodi == $prodi->kode_prodi ? 'selected' : '' }}>
                        {{ $prodi->nama_prodi }}
                    </option>
                @endforeach
            </select>
            <x-forms.error name='prodi'/>

            <label class="label font-bold mt-2" for="jabatan_struktural">Jabatan Struktural</label>
            <input type="text" class="input w-full" name="jabatan_struktural" value="{{ $dosen->jabatan_struktural }}" required />
            <x-forms.error name='jabatan_struktural'/>

            <button class="btn btn-primary mt-6 w-full">Ubah Dosen</button>
        </fieldset>
    </form>
</x-layout>