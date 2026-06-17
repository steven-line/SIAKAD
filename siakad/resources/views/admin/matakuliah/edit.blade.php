<x-layout>
    {{-- PREVIOUS --}}
    <a class="join-item abtn btn-primary"
       href="{{ route('mk.index') }}">
        ⮜ Previous page
    </a>

    {{-- FORM --}}
    <form class="flex h-screen"
          action="{{ route('mk.update', $mk->kodemk) }}"
          method="POST">

        @csrf
        @method('PATCH')

        <fieldset class="fieldset bg-base-200 border-base-300 rounded-box h-100 border p-6 mx-auto mt-10">

            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="label font-bold">KodeMk</label>
                    <input type="text" class="input" name="kodemk"
                           value="{{ $mk->kodemk }}"/>
                    <x-forms.error name="kodemk"/>
                </div>

                <div>
                    <label class="label font-bold">Nama</label>
                    <input type="text" class="input" name="nama"
                           value="{{ $mk->nama }}"/>
                    <x-forms.error name="nama"/>
                </div>

                <div>
                    <label class="label font-bold">SKS</label>
                    <input type="text" class="input" name="sks"
                           value="{{ $mk->sks }}"/>
                    <x-forms.error name="sks"/>
                </div>
            </div>

            <div class="grid grid-cols-4 gap-4">
                <div>
                    <label class="label font-bold">Nama Jenjang Didik</label>
                    <input type="text" class="input" name="nm_jenj_didik"
                           value="{{ $mk->nm_jenj_didik }}"/>
                    <x-forms.error name="nm_jenj_didik"/>
                </div>

                <div>
                    <label class="label font-bold">Kode Prodi Dikti</label>
                    <input type="text" class="input" name="kode_prodi_dikti"
                           value="{{ $mk->kode_prodi_dikti }}"/>
                    <x-forms.error name="kode_prodi_dikti"/>
                </div>

                <div>
                    <label class="label font-bold">Kurikulum</label>
                    <select class="select select-bordered w-full" name="kode_kurikulum">
                        <option disabled>Select Kurikulum</option>
                        @foreach ($kurikulums as $kurikulum)
                            <option value="{{ $kurikulum->kode_kurikulum }}"
                                @selected($mk->kode_kurikulum == $kurikulum->kode_kurikulum)>
                                {{ $kurikulum->kode_kurikulum }} - {{ $kurikulum->nama_kurikulum }}
                            </option>
                        @endforeach
                    </select>
                    <x-forms.error name="kode_kurikulum"/>
                </div>

                <div>
                    <label class="label font-bold">Prasyarat SKS</label>
                    <input type="text" class="input" name="prasyaratsks"
                           value="{{ $mk->prasyaratsks }}"/>
                    <x-forms.error name="prasyaratsks"/>
                </div>
            </div>

            {{-- PRASYARAT --}}
            <div class="grid grid-cols-4 gap-4 mt-4">
                @for ($i = 1; $i <= 10; $i++)
                    <div>
                        <label class="label font-bold">Prasyarat {{ $i }}</label>
                        <input type="text"
                               class="input"
                               name="prasyarat{{ $i }}"
                               value="{{ $mk->{'prasyarat'.$i} }}"/>
                        <x-forms.error name="prasyarat{{ $i }}"/>
                    </div>
                @endfor
            </div>

            <div class="grid grid-cols-4 gap-4 mt-4">
                <div>
                    <label class="label font-bold">Prasyarat Grade</label>
                    <input type="text" class="input" name="prasyaratgrade"
                           value="{{ $mk->prasyaratgrade }}"/>
                    <x-forms.error name="prasyaratgrade"/>
                </div>

                <div>
                    <label class="label font-bold">Aktif</label>
                    <input type="checkbox" class="checkbox" name="aktif"
                        @checked($mk->aktif) />
                    <x-forms.error name="aktif"/>
                </div>
            </div>

            <button class="btn btn-primary mt-4">
                Edit Mata Kuliah
            </button>

        </fieldset>
    </form>
</x-layout>