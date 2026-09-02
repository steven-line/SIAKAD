<x-layout>

    <div class="p-6">

        <a class="join-item btn btn-primary mb-4" href="{{ route('periode.index') }}">
            ⮜ Previous page
        </a>

        <form action="{{ route('periode.store') }}" method="POST">
            @csrf

            <fieldset class="fieldset bg-base-200 border border-base-300 rounded-box w-full max-w-xl mx-auto p-6">

                <legend class="fieldset-legend text-lg font-bold">
                    Tambah Periode
                </legend>

                {{-- TAHUN AJARAN --}}
                <label class="label font-bold">
                    Tahun Ajaran
                </label>

                <div class="grid grid-cols-2 gap-4">

                    {{-- Tahun Mulai --}}
                    <div>

                        <label class="label text-sm">
                            Tahun Mulai
                        </label>

                        <input
                            type="number"
                            id="tahun_mulai"
                            name="tahun_mulai"
                            min="2000"
                            max="2100"
                            value="{{ old('tahun_mulai') }}"
                            class="input input-bordered w-full"
                            placeholder="2026"
                            required
                        />

                        <x-forms.error name="tahun_mulai"/>

                    </div>

                    {{-- Tahun Selesai --}}
                    <div>

                        <label class="label text-sm">
                            Tahun Selesai
                        </label>

                        <input
                            type="number"
                            id="tahun_selesai"
                            class="input input-bordered w-full"
                            placeholder="2027"
                            readonly
                        />

                    </div>

                </div>

                <p class="text-sm text-gray-500 mt-2">
                    Tahun selesai otomatis 1 tahun setelah tahun mulai.
                    Contoh: <b>2026</b> akan menjadi <b>2026/2027</b>.
                </p>

                {{-- TANGGAL MULAI --}}
                <label class="label font-bold mt-4">
                    Tanggal Mulai
                </label>

                <input
                    type="date"
                    name="tanggal_mulai"
                    id="tanggal_mulai"
                    value="{{ old('tanggal_mulai', date('Y-m-d')) }}"
                    class="input input-bordered w-full"
                    required
                />

                <x-forms.error name="tanggal_mulai"/>


                {{-- TANGGAL SELESAI --}}
                <label class="label font-bold">
                    Tanggal Selesai
                </label>

                <input
                    type="date"
                    name="tanggal_selesai"
                    id="tanggal_selesai"
                    value="{{ old('tanggal_selesai') }}"
                    class="input input-bordered w-full"
                    required
                    readonly
                />

                <x-forms.error name="tanggal_selesai"/>

                <p class="text-sm text-gray-500 mt-2">
                    Tanggal selesai dihitung otomatis dari tanggal mulai.
                </p>

                <button class="btn btn-primary mt-6">
                    Buat Periode
                </button>

            </fieldset>

        </form>

    </div>


    {{-- OTOMATIS TAHUN SELESAI --}}
   <script>

        const tahunMulai = document.getElementById('tahun_mulai');
        const tahunSelesai = document.getElementById('tahun_selesai');

        function updateTahunSelesai() {

            if (tahunMulai.value) {

                tahunSelesai.value =
                    parseInt(tahunMulai.value) + 1;

            } else {

                tahunSelesai.value = '';

            }

        }

        tahunMulai.addEventListener('input', updateTahunSelesai);

        updateTahunSelesai();

        const tanggalMulai = document.getElementById('tanggal_mulai');
        const tanggalSelesai = document.getElementById('tanggal_selesai');

        function updateTanggalSelesai() {

            if (!tanggalMulai.value) {
                tanggalSelesai.value = '';
                return;
            }

            const tanggal = new Date(tanggalMulai.value + 'T00:00:00');

            // Tambahkan 11 bulan
            tanggal.setMonth(tanggal.getMonth() + 12);

            const tahun = tanggal.getFullYear();
            const bulan = String(tanggal.getMonth() + 1).padStart(2, '0');
            const hari = String(tanggal.getDate()).padStart(2, '0');

            tanggalSelesai.value =
                `${tahun}-${bulan}-${hari}`;
        }

        tanggalMulai.addEventListener('change', updateTanggalSelesai);

        // Jalankan saat halaman dibuka
        updateTanggalSelesai();

    </script>

</x-layout>