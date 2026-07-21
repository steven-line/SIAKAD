<x-layout>

<div class="card-body">

```
<h2 class="card-title text-2xl font-bold mb-4">
    Detail Periode Akademik
</h2>

<div class="overflow-x-auto">

    <table class="table table-zebra">
        <tbody>

            <tr>
                <th width="30%">Tahun Ajaran</th>
                <td>{{ $periode->tahun_ajaran }}</td>
            </tr>

            <tr>
                <th>Tanggal Mulai</th>
                <td>
                    {{ \Carbon\Carbon::parse($periode->tanggal_mulai)->format('d M Y') }}
                </td>
            </tr>

            <tr>
                <th>Tanggal Selesai</th>
                <td>
                    {{ \Carbon\Carbon::parse($periode->tanggal_selesai)->format('d M Y') }}
                </td>
            </tr>

            <tr>
                <th>Dibuat Pada</th>
                <td>
                    {{ $periode->created_at->format('d M Y H:i') }}
                </td>
            </tr>

            <tr>
                <th>Diupdate Pada</th>
                <td>
                    {{ $periode->updated_at->format('d M Y H:i') }}
                </td>
            </tr>

        </tbody>
    </table>

</div>

{{-- BUTTON --}}
<div class="card-actions justify-end mt-6">


    <a
        href="{{ route('periode.index') }}"
        class="btn btn-primary"
    >
        Kembali
    </a>

</div>
```

</div>

</x-layout>
