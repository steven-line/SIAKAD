<x-layout>

    <div class="p-6">

       <a class="join-item btn btn-primary mb-4" href="{{ route('mahasiswa_admin.index') }}">
        ⮜ Previous page
    </a>
        <form action="{{ route('mahasiswa_admin.store') }}" method="POST">
            @csrf

            <fieldset class="fieldset bg-base-200 border border-base-300 rounded-box w-full max-w-xl mx-auto p-6">

                <legend class="fieldset-legend text-lg font-bold">
                    Tambah Mahasiswa
                </legend>
                <label class="label font-bold mt-4" for="nrp-select">Pilih NRP User</label>
                <select id="nrp-select" name="nrp" class="select select-bordered w-full" required>
                        <option disabled selected>Pilih satu user...</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->username}}" @selected(old('nrp', $user->username) == $user->username)>{{ ucfirst($user->username) }}</option>
                                @endforeach
                </select>
                    
                <x-forms.error name="nrp"/>

                <label class="label font-bold mt-4" for="dosen-wali-select">Pilih Dosen Wali</label>
                <select id="dosen-wali-select" name="dosen_wali" class="select select-bordered w-full" required>
                        <option disabled selected>Pilih satu dosen</option>
                                @foreach($dosens as $dosen)
                                    <option value="{{ $dosen->nim_dosen}}" @selected(old('dosen_wali', $dosen->nim_dosen) == $dosen->nim_dosen)>{{ ucfirst($dosen->nim_dosen) }}</option>
                                @endforeach
                </select>
                    
                <x-forms.error name="dosen_wali"/>
                
                <label class="label font-bold mt-4" for="status-blokir-select">Status Blokir</label>
                <select id="dosen-wali-select" name="status_blokir" class="select select-bordered w-full" required>
                     @foreach(App\Enums\StatusBlokir::cases() as $status)
                        <option value="{{ $status->value }}" @selected(old('status', $status->value) == $status->value)>
                            {{ $status->value}}
                        </option>
                    @endforeach
                </select>
                <x-forms.error name="status_blokir"/>
                <label class="label font-bold mt-4" for="prodi-select">Pilih Prodi</label>
                <select id="prodi-select" name="prodi" class="select select-bordered w-full" required>
                        <option disabled selected>Pilih Prodi.</option>
                                @foreach($prodis as $prodi)
                                    <option value="{{ $prodi->kode_prodi}}" @selected(old('prodi', $prodi->kode_prodi) == $prodi->kode_prodi)>{{ ucfirst($prodi->kode_prodi) }}</option>
                                @endforeach
                </select>
                    
                <x-forms.error name="prodi"/>


                <button class="btn btn-primary mt-6">
                    Buat Mahasiswa
                </button>

            </fieldset>

        </form>

    </div>

</x-layout>
<script>
  function checkNumberFieldLength(elem){
    if (elem.value.length > 4) {
        elem.value = elem.value.slice(0,4); 
    }
}
</script>