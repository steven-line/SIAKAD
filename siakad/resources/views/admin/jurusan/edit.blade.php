<x-layout>

    <a class="join-item btn btn-primary mb-4" href="{{ route('jurusan.index') }}">
        ⮜ Previous page
    </a>

    <form class="flex"
          action="{{ route('jurusan.update', $jurusan->kode_jurusan) }}"
          method="POST">

        @csrf
        @method('PATCH')

        <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-full max-w-xl border p-6 mx-auto">

            <legend class="fieldset-legend text-lg font-bold">
                Edit Jurusan
            </legend>

            {{-- KODE JURUSAN --}}
            <label class="label font-bold" for="kode_jurusan">Kode Jurusan</label>
            <input type="text"
                   maxlength="3"
                   class="input input-bordered w-full"
                   name="kode_jurusan"
                   value="{{ old('kode_jurusan', $jurusan->kode_jurusan) }}" />
            <x-forms.error name="kode_jurusan"/>

            {{-- NAMA JURUSAN --}}
            <label class="label font-bold mt-3" for="nama_jurusan">Nama Jurusan</label>
            <input type="text"
                   maxlength="50"
                   class="input input-bordered w-full"
                   name="nama_jurusan"
                   value="{{ old('nama_jurusan', $jurusan->nama_jurusan) }}" />
            <x-forms.error name="nama_jurusan"/>

            {{-- PROGRAM PENDIDIKAN --}}
            <label class="label font-bold mt-3" for="program_pendidikan">Program Pendidikan</label>
            <input type="text"
                   maxlength="50"
                   class="input input-bordered w-full"
                   name="program_pendidikan"
                   value="{{ old('program_pendidikan', $jurusan->program_pendidikan) }}" />
            <x-forms.error name="program_pendidikan"/>

            {{-- SK BAN --}}
            <label class="label font-bold mt-3" for="sk_ban">SK BAN</label>
            <input type="text"
                   maxlength="50"
                   class="input input-bordered w-full"
                   name="sk_ban"
                   value="{{ old('sk_ban', $jurusan->sk_ban) }}" />
            <x-forms.error name="sk_ban"/>

            {{-- KETERANGAN --}}
            <label class="label font-bold mt-3" for="keterangan">Keterangan</label>
            <textarea name="keterangan"
                      maxlength="255"
                      class="textarea textarea-bordered w-full min-h-28">{{ old('keterangan', $jurusan->keterangan) }}</textarea>
            <x-forms.error name="keterangan"/>

            {{-- FAKULTAS --}}
            <label class="label font-bold mt-3" for="fakultas_id">Fakultas</label>
            <select class="select select-bordered w-full" name="fakultas_id">
                @foreach ($fakultass as $fakultas)
                    <option value="{{ $fakultas->id }}"
                        {{ old('fakultas_id', $jurusan->fakultas_id) == $fakultas->id ? 'selected' : '' }}>
                        {{ $fakultas->nama_fakultas }}
                    </option>
                @endforeach
            </select>
            <x-forms.error name="fakultas_id"/>

            <button class="btn btn-primary mt-6">
                Ubah Jurusan
            </button>

        </fieldset>

    </form>

</x-layout>