<x-layout>  
   
@if ($pengumumanKrs)
    <div role="alert" class="alert alert-info mb-6">
        <span>
            {{$pengumumanKrs}}
        </span>
    </div>
@else
<div class="grid grid-cols-[70%_30%] justify-between px-4 mb-4">
        <div>
            <p class="font-bold">Periode: {{$informasiUmum['periode'] ?? 'N/A'}}</p>
            <p class="font-bold">Semester: {{$informasiUmum['semester'] ?? 'N/A'}}</p>
            <p class="font-bold">Program studi: {{$informasiUmum['program_studi'] ?? 'N/A'}}</p>
        </div>
        <div class="cols-start-2 cols-end-3">
            <p class="font-bold">NRP: {{$informasiUmum['nrp'] ?? 'N/A'}}</p>
            <p class="font-bold">Nama: {{$informasiUmum['nama'] ?? 'N/A'}}</p>
            <p class="font-bold">Dosen Wali: {{$informasiUmum['dosen_wali'] ?? 'N/A'}}</p>
        </div>
        
    </div>

    <hr>
    @foreach($krsMahasiswa as $krs)
    <div class="flex justify-between px-4">
        <div class="font-bold">Periode: {{$krs['periode']}}</div>
        <div class="font-bold mb-4">Semester: {{$krs['semester']}} - <span class="badge badge-primary badge-sm"> {{$loop->iteration}}</span></div>
    </div> 
    <table class="table px-4">
        <thead class="bg-blue-500 text-white">
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Mata Kuliah</th>
                <th>SKS</th>
                <th>Sts</th>
                <th>TTT1</th>
                <th>TTT2</th>
                <th>UTS</th>
                <th>UAS</th>
                <th>LAIN</th>
                <th>GRADE</th>
            </tr>
        </thead>
        <tbody>
          
            @foreach($krs['matkul'] as $item) 
                <tr>
                    
                    <td>{{$loop->iteration}}</td>
                    <td>{{$item['kode']}}</td>
                    <td>{{$item['mata_kuliah']}}</td>
                    <td>{{$item['sks']}}</td>
                    <td>{{$item['status']}}</td>
                    <td>{{$item['ttt1'] ?? '0.00'}} </td>
                    <td>{{$item['ttt2'] ?? '0.00'}}</td>
                    <td>{{$item['uts'] ?? '0.00'}}</td>
                    <td>{{$item['uas'] ?? '0.00'}}</td>
                    <td>{{$item['lain'] ?? '0.00'}}</td>
                    <td>{{$item['grade'] ?? 'E'}}</td>
                </tr>
                
            @endforeach
        </tbody>
        
       
    </table>
         <div class="px-4">
                Total:  {{$krs['total_sks']}} 
            </div>
    @endforeach
@endif
 
</x-layout>