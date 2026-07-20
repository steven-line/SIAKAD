<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\Mk;
use App\Models\Penawaran;
use App\Models\Pjmk;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
class PjmkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Penawaran::select('kodemk')->distinct();
        $user = auth()->user();

        if ($user && $user->dosen) {

            $prodiLogin = $user->dosen->prodi;

        $query
        ->whereHas('mk.kurikulum', function ($q) use ($prodiLogin) {

            $q->where('kode_prodi', $prodiLogin);

        });
        }

        $penawarans = $query
            ->orderBy('hari')
            ->paginate(10, ['kodemk', 'dosen']);
        return view('kaprodi.pjmk.list_matkul', ['penawarans' => $penawarans]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function list_dosen_matkul(Mk $mk) {
        $dosens = Dosen::whereHas('penawaran', function (Builder $query) use ($mk) {
            $query->where('kodemk', $mk->kodemk);
        })->paginate(10);

        /**
         * filter dosen berdasarkan penawaran
         * */ 
        $isPjmk = Dosen::whereHas('pjmk', function (Builder $query) use ($mk) {
            $query->where('kodemk', $mk->kodemk);
        })->get();
        return view('kaprodi.pjmk.list_dosen_matkul', ['dosens' => $dosens, 'mk' => $mk, 'isPjmk' => $isPjmk]);
    }
     public function setPjmk(Mk $mk, Dosen $dosen) {
      
      
        Pjmk::updateOrCreate(['kodemk' => $mk->kodemk],[
                 
                'kodemk' => $mk->kodemk,
                'nim_dosen' => $dosen->nim_dosen,
            ]);

        return redirect()->route('pjmk.list_dosen_matkul', $mk);
    }
}
