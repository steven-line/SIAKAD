<x-layout>  
    <div class="grid grid-cols-[70%_30%] justify-between px-4 mb-4">
        <div>
            <p class="font-bold">Periode: {{$informasiUmum['periode']->tahun_ajaran}}</p>
            <p class="font-bold">Semester: {{$informasiUmum['semester']}}</p>
            <p class="font-bold">Program studi: {{$informasiUmum['program_studi']}}</p>
        </div>
        <div class="cols-start-2 cols-end-3">
            <p class="font-bold">NRP: {{$informasiUmum['nrp']}}</p>
            <p class="font-bold">Nama: {{$informasiUmum['nama']}}</p>
            <p class="font-bold">Dosen Wali: {{$informasiUmum['dosen_wali']}}</p>
        </div>
        
    </div>

    <hr>
    @foreach($grouped as $group)
    <div class="flex justify-between px-4">
        <div class="font-bold">Periode: {{$group['periode']}}</div>
        <div class="font-bold mb-4">Semester: {{$group['semester']}} - <span class="badge badge-primary badge-sm"> {{$loop->iteration}}</span></div>
    </div> 
    <table class="table px-4">
        <thead class="bg-blue-500 text-white">
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Mata Kuliah</th>
                <th>Sks</th>
                <th>Grade</th>
                <th>Mutu</th>
            </tr>
        </thead>
        <tbody>
          
            @foreach($group['items'] as $item) 
                <tr>
                    
                    <td>{{$loop->iteration}}</td>
                    <td>{{$item['kode']}}</td>
                    <td>{{$item['mata_kuliah']}}</td>
                    <td>{{$item['sks']}}</td>
                    <td>{{$item['grade']}}</td>
                    <td>{{$item['mutu']}}</td>
                </tr>
                
           
        </tbody>
         @endforeach
       
    </table>
         <div class="px-4">
                <div>
                     Total:  {{$group['total_sks']}} 
                    </div>
                <div>
                    Total Mutu: {{$group['total_mutu']}}
                </div>
                <div>IPS: {{$group['ips']}}</div>
            </div>
    @endforeach
    <div class="px-4 mt-5">
        IPK: {{ number_format($ipk, 2, '.', '.')}}
    </div>
</x-layout>