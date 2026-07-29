<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RegistrasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('registrasi')->delete();

        $penawaran = DB::table('penawaran')
            ->orderBy('recno')
            ->get();

        $tanggal = Carbon::today();

        $data = [];

        foreach (['31128888','31126666','31125555'] as $nrp) {

            // masing-masing mengambil 3 mata kuliah pertama
            for ($i = 0; $i < 3; $i++) {

                $data[] = [
                    'nrp'          => $nrp,
                    'penawaran_id' => $penawaran[$i]->recno,
                    'status'       => 'A',
                    'tanggal'      => $tanggal,
                    'jam'          => '08:00:00',
                ];
            }
        }

        DB::table('registrasi')->insert($data);
    }
}