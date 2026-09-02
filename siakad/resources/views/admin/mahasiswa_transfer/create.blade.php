<x-layout>
    <a class="join-item btn btn-primary" href="{{route('mahasiswa-transfer.index')}}">⮜ Previous page</a>
    <form class="flex"action="{{route('mahasiswa-transfer.store')}}" method="POST">
    @csrf

    <fieldset class="fieldset bg-base-200 border-base-300 field-sizing-content rounded-box w-xs border p-4 mx-auto">

    

        <label class="label font-bold" for="name">NRP</label>
        <label class="label font-bold mt-4" for="nrp-select">
                    Pilih NRP Mahasiswa
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

                    @foreach($mahasiswas as $mahasiswa)
                        <option
                            value="{{ $mahasiswa->nrp }}"
                          
                            {{ old('nrp') == $mahasiswa->nrp ? 'selected' : '' }}
                        >
                            {{ $mahasiswa->biodata->nama ?? '-' }} - {{ $mahasiswa->nrp }}
                        </option>
                    @endforeach
                </select>

        <x-forms.error name="nrp"/>


        <button class="btn btn-primary mt-4">Buat Nilai Transfer</button>
  </fieldset>

  </form>
</x-layout>