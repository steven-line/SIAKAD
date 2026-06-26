<x-layout>

    <div class="p-6">

       <a class="join-item btn btn-primary mb-4" href="{{ route('semester.index') }}">
        ⮜ Previous page
    </a>
        <form action="{{ route('semester.update', $semester->id) }}" method="POST">
            @csrf
            @method('PATCH')

            <fieldset class="fieldset bg-base-200 border border-base-300 rounded-box w-full max-w-xl mx-auto p-6">

                <legend class="fieldset-legend text-lg font-bold">
                    Ubah Semester
                </legend>
                    <label class="label font-bold" for="nama">
                   Semester
                </label>
                
                <input
                            type="number"
                            class="input input-bordered w-full"
                            name="nama"
                            maxlength="1"
                            value="{{ old('nama', $semester->nama) }}"
                            oninput="this.value=this.value.slice(0,this.maxLength)"
                            
                        />
                <x-forms.error name="nama"/>
                 <label class="label font-bold mt-2" for="periode_id">Periode</label>
                 <select class="select select-bordered w-full" name="periode_id" required>
                    <option disabled selected>Pilih Periode</option>
                    @foreach ($periodes as $periode)
                        <option value="{{ $periode->id }}" @selected(old('periode', $semester->periode_id) == $periode->id)>
                            {{ $periode->tahun_ajaran }}
                        </option>
                    @endforeach
                </select>
                <x-forms.error name="periode_id"/>
                <label class="label font-bold mt-2" for="jenis">Kode Fakultas</label>
                  <select id="jenis-select" name="jenis" class="select select-bordered w-full" required>
                     @foreach(App\Enums\JenisSemester::cases() as $jenis)
                        <option value="{{ $jenis->value }}" @selected(old('jenis', $semester->jenis) == $jenis->value)>
                            {{ $jenis->value}}
                        </option>
                    @endforeach
                </select>
                <x-forms.error name="jenis"/>
                
                <label class="label font-bold" for="aktif">
                    Aktif
                </label>
                  <input
                    type="checkbox"
                    name="aktif"
                    class="checkbox"
                    @checked(old('aktif', $semester->aktif))
                />
                <x-forms.error name="aktif"/>

              

                <button class="btn btn-primary mt-6">
                    Ubah Semester
                </button>

            </fieldset>

        </form>

    </div>

</x-layout>