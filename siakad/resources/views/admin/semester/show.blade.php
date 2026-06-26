<x-layout>

<div class="card-body">

```
<h2 class="card-title text-2xl font-bold mb-4">
    Detail Semester
</h2>

<div class="overflow-x-auto">

    <table class="table table-zebra">
        <tbody>

            <tr>
                <th width="30%">Nama Semester</th>
                <td>Semester {{ $semester->nama }}</td>
            </tr>

            <tr>
                <th>Jenis Semester</th>
                <td>{{ $semester->jenis }}</td>
            </tr>

            <tr>
                <th>Periode</th>
                <td>
                    {{ $semester->periode->tahun_ajaran ?? '-' }}
                </td>
            </tr>

            <tr>
                <th>Status</th>
                <td>
                    @if($semester->aktif)
                        <span class="badge badge-success">Aktif</span>
                    @else
                        <span class="badge badge-error">Tidak Aktif</span>
                    @endif
                </td>
            </tr>

            <tr>
                <th>Dibuat Pada</th>
                <td>
                    {{ $semester->created_at->format('d M Y H:i') }}
                </td>
            </tr>

            <tr>
                <th>Diupdate Pada</th>
                <td>
                    {{ $semester->updated_at->format('d M Y H:i') }}
                </td>
            </tr>

        </tbody>
    </table>

</div>

{{-- BUTTON --}}
<div class="card-actions justify-end mt-6">

    <a
        href="{{ route('semester.edit', $semester->id) }}"
        class="btn btn-warning"
    >
        Edit
    </a>

    <a
        href="{{ route('semester.index') }}"
        class="btn btn-primary"
    >
        Kembali
    </a>

</div>
```

</div>

</x-layout>
