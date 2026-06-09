<x-layout title="KRS UWIKA">
 <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100">
  <table class="table">
    <thead class="bg-green-500 text-white">
      <tr>
        <th>kode</th>
        <th>Mata Kuliah</th>
        <th>Dosen</th>
        <th>Hari</th>
        <th>Jam</th>
        <th>Sks</th>  
      </tr>
    </thead>
    <tbody>
      @forelse ($penawaran as $kodemk)
        <tr>
          <td> <a href="{{ route('mata-kuliah.show', $kodemk->recno) }}" class="text-white-200">{{ $kodemk->kodemk }}</a></td>
          <td> <a href="{{ route('mata-kuliah.show', $kodemk->recno) }}" class="text-white-200">{{ $kodemk->mk->nama ?? '-' }}</a></td>
          <td> <a href="{{ route('mata-kuliah.show', $kodemk->recno) }}" class="text-white-200">{{ $kodemk->dosen }}</a></td>
          <td> <a href="{{ route('mata-kuliah.show', $kodemk->recno) }}" class="text-white-200">{{ $kodemk->hari }}</a></td>
          <td> <a href="{{ route('mata-kuliah.show', $kodemk->recno) }}" class="text-white-200">{{ $kodemk->mulaipukul->format('H:i:s') }} - {{ $kodemk->selesaipukul->format('H:i:s') }}</a></td>
          <td> <a href="{{ route('mata-kuliah.show', $kodemk->recno) }}" class="text-white-200">{{ $kodemk->mk->sks ?? '-' }}</a></td>
        </tr>
      @empty
        <tr>
          <td colspan="7" class="text-center py-4">Tidak ada data mata kuliah</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>
</x-layout>