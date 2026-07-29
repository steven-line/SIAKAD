<x-layout title="KRS UWIKA">

    @if($statusBlokir === 'BLOKIR')

        <div role="alert" class="alert alert-error mb-6">
            <span>
                KRS anda terblokir, mohon hubungi bagian keuangan untuk menyelesaikan tunggakan.
            </span>
        </div>

    @else

        @if($statusBlokir === 'TERKUNCI')
            <div role="alert" class="alert alert-warning mb-6">
                <span>
                    KRS Anda sedang terkunci. Anda masih dapat melihat data, tetapi tidak dapat melakukan perubahan.
                </span>
            </div>
        @endif

        {{-- Alert Pengumuman Nilai Final --}}
        @if(!empty($periodePengumuman))

            <div role="alert" class="alert alert-warning mb-6">
                <div>
                    <h3 class="font-bold">
                        Pengumuman
                    </h3>

                    <div class="mt-1">
                        Nilai KRS sedang tidak dapat diakses karena sedang dalam periode
                        <b>Pengumuman Nilai Final</b>.

                        <br><br>

                        Nilai dapat diakses kembali setelah

                        <b>
                            {{ \Carbon\Carbon::parse($pengumumanSelesai)->translatedFormat('d F Y, H:i') }}
                            WIB
                        </b>.
                    </div>
                </div>
            </div>

        @else

            {{-- ✅ TERKUNCI / NORMAL --}}
            {{-- HEADER --}}
            <div class="mb-4">
                <div>
                    Periode: {{ $periodeAktif ? $periodeAktif->tahun_ajaran : '-' }}
                </div>
                <div>
                    Semester: {{ $semesterKe ?? "-" }} - {{ $semesterAktif ? $semesterAktif->jenis : '-' }}
                </div>
            </div>

            {{-- LOOP PER PERIODE --}}
            @foreach ($nilaiKrsGrouped as $tahun => $semesters)
            @foreach ($semesters as $jenis => $wrap)
                @php
                    $items = $wrap['data'];
                    $semesterKe = $wrap['semester_ke'];
                @endphp

                <div class="mb-4">
                    <div class="flex justify-between font-semibold">
                        <div>
                            Periode : {{ $tahun }}
                        </div>
                        <div>
                            Semester : {{ $semesterKe ?? "-" }} - {{ strtoupper($jenis) }}
                        </div>
                    </div>
                </div>

                <div class="mb-6">
                    <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100">
                        <table class="table w-full">
                            <thead class="bg-green-500 text-white">
                                <tr>
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Mata Kuliah</th>
                                    <th>SKS</th>
                                    <th>TTT1</th>
                                    <th>TTT2</th>
                                    <th>UTS</th>
                                    <th>UAS</th>
                                    <th>Grade</th>
                                    <th>Periode</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $i => $item)
                                    <tr>
                                        <td>{{ $i+1 }}</td>
                                        <td>{{ $item->kode }}</td>
                                        <td>{{ $item->nama_mk }}</td>
                                        <td>{{ $item->sks }}</td>
                                        <td>{{ $item->ttt1 ?? '-' }}</td>
                                        <td>{{ $item->ttt2 ?? '-' }}</td>
                                        <td>{{ $item->uts ?? '-' }}</td>
                                        <td>{{ $item->uas ?? '-' }}</td>
                                        <td>{{ $item->na ?? '-' }}</td>
                                        <td>{{ $item->tahun_ajaran }}</td>
                                    </tr>
                                @endforeach

                                {{-- TOTAL SKS --}}
                                <tr class="font-bold">
                                    <td colspan="3" class="text-right">TOTAL</td>
                                    <td>
                                        {{ $items->sum('sks') }}
                                    </td>
                                    <td colspan="6"></td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>

            @endforeach

        @endforeach
                    </tbody>
                </table>
            </div>

        @endif

    @endif

</x-layout>