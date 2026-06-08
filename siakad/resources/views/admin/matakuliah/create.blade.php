<x-layout>
    <a class="join-item abtn btn-primary" href="/admin/kelola-matakuliah">⮜ Previous page</a>
    <form class="flex h-screen"action="/admin/kelola-matakuliah" method="POST">
    @csrf
    <fieldset class="fieldset bg-base-200 border-base-300 rounded-box h-100 border p-6 mx-auto mt-10 ">
        <div class="grid grid-cols-3 gap-4">
             <div>
                <label class="label font-bold" for="kodemk">KodeMk</label>
                <input type="text" class="input" name="kodemk" placeholder="TF2028" />
                 <x-forms.error name='kodemk'/>
             </div>
             
             
             <div>                
                <label class="label font-bold" for="nama">Nama</label>
                <input type="text" class="input" name="nama" placeholder="Aljabar Linear Matriks" />
                 <x-forms.error name='nama'/>
             </div>
              <div>
                <label class="label font-bold" for="sks">SKS</label>
                <input type="text" class="input" name="sks" placeholder="3" />
                <x-forms.error name='sks'/>
            </div>
        </div>
        <div class="grid grid-cols-4">
            <div>
              <label class="label font-bold" for="nm_jenj_didik">Nama Jenjang Didik</label>
              <input type="text" class="input" name="nm_jenj_didik" placeholder="" />
               <x-forms.error name='nm_jenj_didik'/>
            </div>
            <div>
                <label class="label font-bold" for="kode_prodi_dikti">Kode Prodi Dikti</label>
               <input type="text" class="input" name="kode_prodi_dikti" placeholder="" />
                <x-forms.error name='kode_prodi_dikti'/>
            </div>

            <div class="flex flex-col ml-2 mr-2">
                <label class="label font-bold align-center" for="kode_kurikulum">Kurikulum</label>
                 <select class="select select-bordered  align-center w-full" name="kode_kurikulum" required>
                <option disabled selected>Select Kurikulum</option>
                @foreach ($kurikulums as $kurikulum)  
                    <option value="{{ $kurikulum->kode_kurikulum }}">{{$kurikulum->kode_kurikulum}} - {{ $kurikulum->nama_kurikulum }}</option>  
                @endforeach
            </select>
            <x-forms.error name='kode_kurikulum'/>
            </div>
          
            <div>
                
                <label class="label font-bold" for="prasyaratsks">Prasyarat Sks</label>
                <input type="text" class="input" name="prasyaratsks" placeholder="" />
                <x-forms.error name='prasyaratsks'/>
            </div>
        </div>
        <div class="grid grid-cols-4 gap-4">
            <div> 
                 <label class="label font-bold" for="prasyarat1">Prasyarat 1</label>
                 <input type="text" class="input" name="prasyarat1" placeholder="" /> 
                 <x-forms.error name='prasyarat1'/> 
            </div>
            <div>
                <label class="label font-bold" for="prasyarat2">Prasyarat 2</label>
                <input type="text" class="input" name="prasyarat2" placeholder="" />
                <x-forms.error name='prasyarat2'/> 
            </div>
            <div>
                <label class="label font-bold" for="prasyarat3">Prasyarat 3</label>
                <input type="text" class="input" name="prasyarat3" placeholder="" />
                <x-forms.error name='prasyarat3'/> 
            </div>
            <div>
                
                 <label class="label font-bold" for="prasyarat4">Prasyarat 4</label>
                 <input type="text" class="input" name="prasyarat4" placeholder="" />
                 <x-forms.error name='prasyarat4'/> 
            </div>
          
           
        </div>
        <div class="grid grid-cols-4 gap-4">
            <div>
                 <label class="label font-bold" for="prasyarat5">Prasyarat 5</label>
                 <input type="text" class="input" name="prasyarat5" placeholder="" />
                 <x-forms.error name='prasyarat5'/> 
            </div>
            <div>
                 <label class="label font-bold" for="prasyarat6">Prasyarat 6</label>
                 <input type="text" class="input" name="prasyarat6" placeholder="" />
                 <x-forms.error name='prasyarat6'/> 
            </div>
            <div>
                <label class="label font-bold" for="prasyarat7">Prasyarat 7</label>
               <input type="text" class="input" name="prasyarat7" placeholder="" />
               <x-forms.error name='prasyarat7'/> 
            </div>
            <div>
                <label class="label font-bold" for="prasyarat8">Prasyarat 8</label>
                <input type="text" class="input" name="prasyarat8" placeholder="" />
                <x-forms.error name='prasyarat8'/> 
            </div>
          
            

        </div>
        <div class="grid grid-cols-4 gap-4"> 
              
            <div>
                <label class="label font-bold" for="prasyarat9">Prasyarat 9</label>
                <input type="text" class="input" name="prasyarat9" placeholder="" />
                <x-forms.error name='prasyarat9'/> 
            </div>
            <div>
                  <label class="label font-bold" for="prasyarat10">Prasyarat 10</label>
                  <input type="text" class="input" name="prasyarat10" placeholder="" />
                  <x-forms.error name='prasyarat10'/> 
            </div>
            <div>
                        
                <label class="label font-bold" for="prasyaratgrade">Prasyarat Grade</label>
                <input type="text" class="input" name="prasyaratgrade" placeholder="" />
                <x-forms.error name='prasyaratgrade'/> 
            </div>

            <div>   
                <label class="label font-bold" for="aktif">aktif</label>
                <div>
                     <input type="checkbox" class="checkbox" name="aktif" placeholder="" />
                     <x-forms.error name='aktif'/>
                </div>
               
            </div>
       
    
        </div>
      
               


        <button class="btn btn-primary mt-2">Buat Mata Kuliah</button>
  </fieldset>

  </form>
</x-layout>