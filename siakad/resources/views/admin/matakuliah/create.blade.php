<x-layout>

    <a class="btn btn-primary" href="{{ route('mk.index') }}">
        ⮜ Previous page
    </a>

    <form class="flex h-screen" action="{{ route('mk.store') }}" method="POST">
        @csrf

        <fieldset class="fieldset bg-base-200 border-base-300 rounded-box h-100 border p-6 mx-auto mt-10">

            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="label font-bold" for="kodemk">KodeMk</label>
                    <input type="text" class="input" name="kodemk" value="{{old('kodemk')}}" placeholder="TF2028" maxlength="8"/>
                    <x-forms.error name='kodemk'/>
                </div>

                <div>
                    <label class="label font-bold" for="nama">Nama</label>
                    <input type="text" class="input" name="nama" maxlength="50" placeholder="Aljabar Linear Matriks" value="{{old('nama')}}"/>
                    <x-forms.error name='nama'/>
                </div>

                <div>
                    <label class="label font-bold" for="sks">SKS</label>
                    <input type="text" class="input" name="sks" maxlength="3" value="{{old('sks')}}"/>
                    <x-forms.error name='sks'/>
                </div>
            </div>

            <div class="grid grid-cols-4 mt-4">
                <div>
                    <label class="label font-bold" for="nm_jenj_didik">Nama Jenjang Didik</label>
                    <input type="text" class="input" maxlength="2" name="nm_jenj_didik" value="{{old('nm_jenj_didik')}}"/>
                    <x-forms.error name='nm_jenj_didik'/>
                </div>

                <div>
                    <label class="label font-bold" for="kode_prodi_dikti">Kode Prodi Dikti</label>
                    <input type="text" class="input" maxlength="5" name="kode_prodi_dikti" value="{{old('kode_prodi_dikti')}}"/>
                    <x-forms.error name='kode_prodi_dikti'/>
                </div>

                <div>
                    <label class="label font-bold" for="kode_kurikulum">Kurikulum</label>
                    <select class="select select-bordered w-full" name="kode_kurikulum" required>
                        <option disabled selected>Select Kurikulum</option>
                        @foreach ($kurikulums as $kurikulum)
                            <option value="{{ $kurikulum->kode_kurikulum }}">
                                {{ $kurikulum->kode_kurikulum }} - {{ $kurikulum->nama_kurikulum }}
                            </option>
                        @endforeach
                    </select>
                    <x-forms.error name='kode_kurikulum'/>
                </div>

                <div>
                    <label class="label font-bold" for="prasyaratsks">Prasyarat SKS</label>
                    <input type="text" class="input" name="prasyaratsks" value="{{old('prasyaratsks')}}" maxlength="3"/>
                    <x-forms.error name='prasyaratsks'/>
                </div>
            </div>

            {{-- PRASYARAT --}}
            <div class="grid grid-cols-4 gap-4 mt-4">
                @for ($i = 1; $i <= 4; $i++)
                <div>
                    <label class="label font-bold">Prasyarat {{ $i }}</label>
                    <input type="text" class="input" name="prasyarat{{ $i }}" value="{{old('prasyarat'.$i)}}" maxlength="8"/>
                    <x-forms.error name="prasyarat{{ $i }}"/>
                </div>
                @endfor
            </div>

            <div class="grid grid-cols-4 gap-4 mt-4">
                @for ($i = 5; $i <= 8; $i++)
                <div>
                    <label class="label font-bold">Prasyarat {{ $i }}</label>
                    <input type="text" class="input" name="prasyarat{{ $i }}" value="{{old('prasyarat'.$i)}}" maxlength="8"/>
                    <x-forms.error name="prasyarat{{ $i }}"/>
                </div>
                @endfor
            </div>

            <div class="grid grid-cols-4 gap-4 mt-4">
                @for ($i = 9; $i <= 10; $i++)
                <div>
                    <label class="label font-bold">Prasyarat {{ $i }}</label>
                    <input type="text" class="input" name="prasyarat{{ $i }}" value="{{old('prasyarat'.$i)}}" maxlength="8"/>
                    <x-forms.error name="prasyarat{{ $i }}"/>
                </div>
                @endfor

                <div>
                    <label class="label font-bold">Prasyarat Grade</label>
                    <input type="text" class="input" name="prasyaratgrade" value="{{old('prasyaratgrade')}}" maxlength="1"  />
                    <x-forms.error name='prasyaratgrade'/>
                </div>

                <div>
                    <label class="label font-bold">Aktif</label>
                    <input type="checkbox" class="checkbox" name="aktif" />
                </div>
            </div>

            <button class="btn btn-primary mt-4">
                Buat Mata Kuliah
            </button>

        </fieldset>
    </form>

</x-layout>