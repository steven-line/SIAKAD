<x-layout title="index">
 <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100">
  <table class="table">
    <!-- head -->
    <thead class="bg-blue-500 text-white">
      <tr>
        <th>Id</th>
        <th>kode_mk</th>
        <th>nama_mk</th>
        <th>kelas</th>
        <th>hari</th>
        <th>jam_mulai</th>
        <th>jam_selesai</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($jadwals as $jadwal)
        <tr>
          <td>{{ $jadwal->id }}</td>
          <td>{{ $jadwal->kode_mk }}</td>
          <td>{{ $jadwal->nama_mk }}</td>
          <td>{{ $jadwal->kelas }}</td>
          <td>{{ $jadwal->hari }}</td>
          <td>{{ $jadwal->jam_mulai }}</td>
          <td>{{ $jadwal->jam_selesai }}</td>
        </tr>
        @endforeach
    </tbody>
  </table>
</div>
</x-layout>