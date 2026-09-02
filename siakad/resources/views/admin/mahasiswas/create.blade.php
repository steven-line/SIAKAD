<x-layout>

    <div class="p-6">

        <a class="join-item btn btn-primary mb-4"
           href="{{ route('mahasiswa_admin.index') }}">
            ⮜ Previous page
        </a>

        <form action="{{ route('mahasiswa_admin.store') }}" method="POST">
            @csrf

            <fieldset class="fieldset bg-base-200 border border-base-300 rounded-box w-full max-w-xl mx-auto p-6">

                <legend class="fieldset-legend text-lg font-bold">
                    Tambah Mahasiswa
                </legend>

                {{-- PRODI --}}
                <label class="label font-bold mt-4" for="prodi-select">
                    Pilih Prodi
                </label>

                <select
                    id="prodi-select"
                    name="prodi"
                    class="select select-bordered w-full"
                    required
                >
                    <option value="" disabled selected>
                        Pilih Prodi
                    </option>

                    @foreach($prodis as $prodi)
                        <option
                            value="{{ $prodi->kode_prodi }}"
                            {{ old('prodi') == $prodi->kode_prodi ? 'selected' : '' }}
                        >
                            {{ $prodi->kode_prodi }} - {{ $prodi->nama_prodi }}
                        </option>
                    @endforeach
                </select>

                <x-forms.error name="prodi"/>


                {{-- NRP USER --}}
                <label class="label font-bold mt-4" for="nrp-select">
                    Pilih NRP User Baru
                </label>

                <select
                    id="nrp-select"
                    name="nrp"
                    class="select select-bordered w-full"
                    required
                >
                    <option value="" disabled selected>
                        Pilih Prodi terlebih dahulu
                    </option>

                    @foreach($users as $user)
                        <option
                            value="{{ $user->username }}"
                            data-nrp-prefix="{{ substr($user->username, 0, 3) }}"
                            {{ old('nrp') == $user->username ? 'selected' : '' }}
                        >
                            {{ $user->username }}
                        </option>
                    @endforeach
                </select>

                <x-forms.error name="nrp"/>


                {{-- DOSEN WALI --}}
                <label class="label font-bold mt-4" for="dosen-wali-select">
                    Pilih Dosen Wali
                </label>

                <select
                    id="dosen-wali-select"
                    name="dosen_wali"
                    class="select select-bordered w-full"
                    required
                >
                    <option value="" disabled selected>
                        Pilih Prodi terlebih dahulu
                    </option>

                    @foreach($dosens as $dosen)
                        <option
                            value="{{ $dosen->nim_dosen }}"
                            data-prodi="{{ $dosen->prodi }}"
                            {{ old('dosen_wali') == $dosen->nim_dosen ? 'selected' : '' }}
                        >
                            {{ $dosen->nim_dosen }} - {{ $dosen->nama }}
                        </option>
                    @endforeach
                </select>

                <x-forms.error name="dosen_wali"/>


                {{-- TAHUN MASUK --}}
                <label class="label font-bold mt-4" for="tahun-masuk">
                    Tahun Masuk
                </label>

                <input
                    type="number"
                    id="tahun-masuk"
                    name="tahun_masuk"
                    class="input input-bordered w-full"
                    min="2000"
                    max="{{ date('Y') }}"
                    value="{{ old('tahun_masuk') }}"
                    placeholder="Contoh: 2023"
                    required
                />

                <x-forms.error name="tahun_masuk"/>


                {{-- STATUS BLOKIR --}}
                <label class="label font-bold mt-4" for="status-blokir-select">
                    Status Blokir
                </label>

                <select
                    id="status-blokir-select"
                    name="status_blokir"
                    class="select select-bordered w-full"
                    required
                >
                    @foreach(App\Enums\StatusBlokir::cases() as $status)
                        <option
                            value="{{ $status->value }}"
                            {{ old('status_blokir', 'BELUM_KRS') == $status->value ? 'selected' : '' }}
                        >
                            {{ $status->value }}
                        </option>
                    @endforeach
                </select>

                <x-forms.error name="status_blokir"/>
                 
                <label class="label font-bold mt-4" for="transfer-checkbox">Transfer</label>
                <input type="checkbox"  value="1" class="checkbox checkbox-primary" name="transfer" id="transfer-checkbox"/>
                <x-forms.error name="transfer"/>

                 <label class="label font-bold mt-4" for="semester_transfer">
                    Semester Transfer
                </label>

                <input
                    type="number"
                    min="1"
                    max="14"
                    id="semester_transfer"
                    name="semester_transfer"
                    class="input w-full"
                    value="{{ old('semester') }}"
                    placeholder="Contoh: 1"
                    required
                    
                />

                <x-forms.error name="semester_transfer"/>

                
                <button class="btn btn-primary mt-6">
                    Buat Mahasiswa
                </button>

            </fieldset>

        </form>

    </div>

</x-layout>

<script>
    const prodiSelect = document.getElementById('prodi-select');
    const nrpSelect = document.getElementById('nrp-select');
    const dosenSelect = document.getElementById('dosen-wali-select');

    const nrpPrefixMap = {
        C: '111',
        D: '112',
        F: '211',
        G: '212',
        H: '213',
        I: '311',
        K: '614',
        L: '615'
    };

    function filterMahasiswaDanDosen() {

        const prodi = prodiSelect.value;

        // ==============================
        // FILTER NRP
        // ==============================

        const prefix = nrpPrefixMap[prodi];

        nrpSelect.value = '';

        let adaNrp = false;

        Array.from(nrpSelect.options).forEach(option => {

            if (!option.value) {
                option.hidden = false;
                return;
            }

            const nrpPrefix = option.dataset.nrpPrefix;

            if (nrpPrefix === prefix) {
                option.hidden = false;
                adaNrp = true;
            } else {
                option.hidden = true;
            }
        });

        if (!adaNrp) {
            nrpSelect.innerHTML = `
                <option value="" disabled selected>
                    Tidak ada user mahasiswa untuk prodi ini
                </option>
            `;
        } else {
            nrpSelect.querySelector('option[value=""]')?.remove();

            const placeholder = document.createElement('option');
            placeholder.value = '';
            placeholder.textContent = 'Pilih satu user...';
            placeholder.disabled = true;
            placeholder.selected = true;

            nrpSelect.insertBefore(
                placeholder,
                nrpSelect.firstChild
            );
        }


        // ==============================
        // FILTER DOSEN WALI
        // ==============================

        dosenSelect.value = '';

        let adaDosen = false;

        Array.from(dosenSelect.options).forEach(option => {

            if (!option.value) {
                option.hidden = false;
                return;
            }

            if (option.dataset.prodi === prodi) {
                option.hidden = false;
                adaDosen = true;
            } else {
                option.hidden = true;
            }
        });

        if (!adaDosen) {

            dosenSelect.innerHTML = `
                <option value="" disabled selected>
                    Tidak ada dosen untuk prodi ini
                </option>
            `;

        } else {

            const placeholder = document.createElement('option');

            placeholder.value = '';
            placeholder.textContent = 'Pilih satu dosen';
            placeholder.disabled = true;
            placeholder.selected = true;

            dosenSelect.insertBefore(
                placeholder,
                dosenSelect.firstChild
            );
        }
    }

    prodiSelect.addEventListener('change', filterMahasiswaDanDosen);

    // Jalankan saat halaman dibuka jika ada old('prodi')
    if (prodiSelect.value) {
        filterMahasiswaDanDosen();
    }

function checkNumberFieldLength(elem){
    if (elem.value.length > 4) {
        elem.value = elem.value.slice(0,4); 
    }
}   
</script>