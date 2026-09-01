<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\Mk;
use App\Models\Penawaran;
use App\Models\Periode;
use App\Models\Pjmk;
use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
class PjmkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
 public function index()
    {
        $user = auth()->user();

        // ADMIN
        if ($user->can('pjmk.manage') && !$user->dosen) {

            $penawarans = Penawaran::leftJoin(
                    'semester',
                    'penawaran.semester_id',
                    '=',
                    'semester.id'
                )
                ->leftJoin(
                    'periode',
                    'semester.periode_id',
                    '=',
                    'periode.id'
                )
                ->select(
                    'semester.jenis',
                    'periode.tahun_ajaran',
                    'penawaran.kodemk',
                    'periode.id as periode_id'
                )
                ->with('mk')
                ->distinct()
                ->paginate(10);

            return view('kaprodi.pjmk.list_matkul', [
                'penawarans' => $penawarans
            ]);
        }

        // KAPRODI
        if ($user->dosen) {

            $prodiLogin = $user->dosen->prodi;

            $penawarans = Penawaran::leftJoin(
                    'semester',
                    'penawaran.semester_id',
                    '=',
                    'semester.id'
                )
                ->leftJoin(
                    'periode',
                    'semester.periode_id',
                    '=',
                    'periode.id'
                )
                ->select(
                    'semester.jenis',
                    'periode.tahun_ajaran',
                    'penawaran.kodemk',
                    'periode.id as periode_id'
                )
                ->whereHas('mk.kurikulum', function ($q) use ($prodiLogin) {
                    $q->where('kode_prodi', $prodiLogin);
                })
                ->with('mk')
                ->distinct()
                ->paginate(10);

            return view('kaprodi.pjmk.list_matkul', [
                'penawarans' => $penawarans
            ]);
        }

        abort(403);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function list_dosen_matkul(Periode $periode, Semester $semester, Mk $mk) {
        /** List dosen dengan */
        $dosens = Dosen::whereHas('penawaran.semester', function(Builder $query) use ($periode, $semester) {
                        $query->where('jenis', $semester->jenis);
                        $query->where('periode_id', $periode->id);

                    })->whereHas('penawaran', function(Builder $query) use ($mk){
                        $query->where('kodemk', $mk->kodemk);
                    })->paginate(10);
         $currentPjmk = Pjmk::where('kodemk', $mk->kodemk)
                        ->where('periode_id', $periode->id)
                        ->where('jenis', $semester->jenis)
                        ->first();
       
        return view('kaprodi.pjmk.list_dosen_matkul', ['dosens' => $dosens, 'periode' => $periode, 'semester' => $semester, 'mk' => $mk, 'currentPjmk' => $currentPjmk]);
    }

    public function setPjmk(Request $request) {

        $request->validate([
            'nim_dosen' => 'exists:dosen,nim_dosen',
            'kodemk' => 'exists:mk,kodemk',
            'periode_id'  => 'exists:periode,id',
            'jenis'      => 'required|in:Ganjil,Genap' 
        ]);
        Pjmk::updateOrCreate([
            'kodemk' => $request->kodemk, 
            'periode_id' => $request->periode_id,    
            'jenis'  => $request->jenis ],[
                'nim_dosen' => $request->nim_dosen,]
              
        );

       
        return redirect()->back()->with('success', 'PJMK untuk mata kuliah ini berhasil disimpan!');
    }
  
}
