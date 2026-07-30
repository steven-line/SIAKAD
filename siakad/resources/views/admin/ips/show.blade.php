<x-layout title="Kelola SKS Mahasiswa">

<div class="max-w-3xl mx-auto">

    <a href="{{ route('ips.index') }}"
       class="btn btn-primary mb-6">
        ⮜ Kembali
    </a>

    @if(session('success'))
        <div class="alert alert-success mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-error mb-4">
            <ul class="list-disc ml-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card bg-base-100 shadow">

        <div class="card-body">

            <h2 class="card-title mb-4">
                Kelola SKS Mahasiswa
            </h2>

            <div class="grid grid-cols-2 gap-4">

                <div>
                    <label class="font-semibold">
                        NRP
                    </label>

                    <input
                        type="text"
                        class="input input-bordered w-full"
                        value="{{ $ips->nrp }}"
                        readonly>
                </div>

                <div>
                    <label class="font-semibold">
                        Nama Mahasiswa
                    </label>

                    <input
                        type="text"
                        class="input input-bordered w-full"
                        value="{{ $ips->mahasiswa->biodata->nama ?? '-' }}"
                        readonly>
                </div>

                <div>
                    <label class="font-semibold">
                        IPS
                    </label>

                    <input
                        type="text"
                        class="input input-bordered w-full"
                        value="{{ number_format($ips->ips, 3) }}"
                        readonly>
                </div>

                <div>
                    <label class="font-semibold">
                        Maksimal SKS
                    </label>

                    <input
                        type="text"
                        class="input input-bordered w-full"
                        value="{{ $ips->maksimal_sks }}"
                        readonly>
                </div>

            </div>

            <form
                action="{{ route('ips.update', $ips->nrp) }}"
                method="POST"
                class="mt-6">

                @csrf
                @method('PUT')

                <div>

                    <label class="font-semibold">
                        Toleransi SKS
                    </label>

                    @if($ips->maksimal_sks == 21)

                        <select name="toleransi" class="select select-bordered w-full">
                            <option value="0" {{ $ips->toleransi == 0 ? 'selected' : '' }}>
                                0 SKS
                            </option>

                            <option value="1" {{ $ips->toleransi == 1 ? 'selected' : '' }}>
                                1 SKS
                            </option>

                            <option value="2" {{ $ips->toleransi == 2 ? 'selected' : '' }}>
                                2 SKS
                            </option>
                        </select>

                        <p class="text-xs text-gray-500 mt-2">
                            Toleransi hanya dapat diberikan kepada mahasiswa
                            dengan maksimal SKS 21.
                        </p>

                    @else

                        <input
                            type="text"
                            class="input input-bordered w-full"
                            value="Tidak dapat diberikan (Maksimal SKS sudah 24)"
                            readonly>

                        <input type="hidden" name="toleransi" value="0">

                    @endif

                </div>

                <div class="mt-6">

                    <button
                        type="submit"
                        class="btn btn-success"
                        {{ $ips->maksimal_sks == 24 ? 'disabled' : '' }}>

                        Simpan Perubahan

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

</x-layout>