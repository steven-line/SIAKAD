<x-layout>

<div class="p-6">

    <a class="btn btn-primary mb-6" href="{{ url()->previous() }}">
        ⮜ Previous page
    </a>

    <div class="card bg-base-200 border border-base-300 shadow-xl max-w-4xl mx-auto">

        <div class="card-body">

            <h2 class="card-title text-2xl font-bold mb-6">
                Detail Nilai KRS
            </h2>

            @if(!$krs)

                <div class="alert alert-warning mb-6">
                    <span>
                        Nilai untuk mahasiswa ini belum pernah diinput.
                    </span>
                </div>

            @endif

            {{-- IDENTITAS --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

                <div>
                    <p class="font-semibold text-base-content/70">NRP</p>
                    <p class="text-lg">
                        {{ $mahasiswa->nrp }}
                    </p>
                </div>

                <div>
                    <p class="font-semibold text-base-content/70">Kode MK</p>
                    <p class="text-lg">
                        {{ $mk->kodemk }}
                    </p>
                </div>

                <div>
                    <p class="font-semibold text-base-content/70">Mata Kuliah</p>
                    <p class="text-lg">
                        {{ $mk->nama ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="font-semibold text-base-content/70">SKS</p>
                    <p class="text-lg">
                        {{ $mk->sks ?? '-' }}
                    </p>
                </div>

            </div>

            {{-- TABEL NILAI --}}
            <div class="overflow-x-auto">

                <table class="table table-zebra">

                    <thead class="bg-base-300">
                        <tr>
                            <th>Komponen</th>
                            <th>Nilai</th>
                        </tr>
                    </thead>

                    <tbody>

                        <tr>
                            <td>Kelas</td>
                            <td>{{ $krs?->kelas ?? '-' }}</td>
                        </tr>

                        <tr>
                            <td>Semester</td>
                            <td>
                                {{ $krs?->registrasi?->penawaran?->semester?->periode?->tahun_ajaran ?? '-' }}
                                -
                                {{ $krs?->registrasi?->penawaran?->semester?->jenis ?? '-' }}
                            </td>
                        </tr>

                        <tr>
                            <td>BU</td>
                            <td>{{ $krs?->bu ?? '-' }}</td>
                        </tr>

                        <tr>
                            <td>TTT 1</td>
                            <td>{{ $krs?->ttt1 ?? '-' }}</td>
                        </tr>

                        <tr>
                            <td>TTT 2</td>
                            <td>{{ $krs?->ttt2 ?? '-' }}</td>
                        </tr>

                        <tr>
                            <td>TTT 3</td>
                            <td>{{ $krs?->ttt3 ?? '-' }}</td>
                        </tr>

                        <tr>
                            <td>Lain-lain</td>
                            <td>{{ $krs?->lain ?? '-' }}</td>
                        </tr>

                        <tr>
                            <td>UTS</td>
                            <td>{{ $krs?->uts ?? '-' }}</td>
                        </tr>

                        <tr>
                            <td>UAS</td>
                            <td>{{ $krs?->uas ?? '-' }}</td>
                        </tr>

                        <tr>
                            <td>Nilai Akhir (NA)</td>
                            <td class="font-bold">
                                {{ $krs?->na ?? '-' }}
                            </td>
                        </tr>

                        <tr>
                            <td>SKS</td>
                            <td>
                                {{ $krs?->sks ?? $mk->sks ?? '-' }}
                            </td>
                        </tr>

                        <tr>
                            <td>Survey</td>
                            <td>

                                @if(!$krs)
                                    <span class="badge badge-neutral">
                                        Belum Ada Nilai
                                    </span>

                                @elseif($krs->survey)
                                    <span class="badge badge-success">
                                        Sudah
                                    </span>

                                @else
                                    <span class="badge badge-error">
                                        Belum
                                    </span>
                                @endif

                            </td>
                        </tr>

                    </tbody>

                </table>

            </div>

            {{-- ACTION --}}
            <div class="card-actions justify-end mt-6">

                @if($krs)

                    <a href="{{ route('nilai.edit', [
                        'mahasiswa' => $mahasiswa->nrp,
                        'mk' => $mk->kodemk
                    ]) }}"
                       class="btn btn-warning">
                        Edit Nilai
                    </a>

                @else

                    <a href="{{ route('nilai.create', [
                        'mahasiswa' => $mahasiswa->nrp,
                        'mk' => $mk->kodemk
                    ]) }}"
                       class="btn btn-primary">
                        Input Nilai
                    </a>

                @endif

            </div>

        </div>

    </div>

</div>

</x-layout>