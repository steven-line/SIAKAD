<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KrsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('krs')->delete();

        $registrasi = DB::table('registrasi')
            ->orderBy('regkrs')
            ->get();

        /*
        urutan nilai
        mahasiswa 1 : A A AB
        mahasiswa 2 : AB B B
        mahasiswa 3 : BC C D
        */

        $nilai = [
            ['A', 90,92,95,90,95],
            ['A', 88,90,92,88,94],
            ['AB',80,82,84,83,85],

            ['AB',82,83,84,82,84],
            ['B',75,76,77,78,79],
            ['B',74,75,76,77,78],

            ['BC',68,70,72,70,71],
            ['C',60,62,63,61,60],
            ['D',45,48,50,47,49],
        ];

        $data = [];

        foreach ($registrasi as $index => $reg) {

            $penawaran = DB::table('penawaran')
                ->where('recno', $reg->penawaran_id)
                ->first();

            $mk = DB::table('mk')
                ->where('kodemk', $penawaran->kodemk)
                ->first();

            $n = $nilai[$index];

            $data[] = [
                'registrasi_id' => $reg->regkrs,

                'bu' => null,

                'ttt1' => $n[1],
                'ttt2' => $n[2],
                'ttt3' => $n[3],

                'lain' => 90,

                'uts' => $n[4],
                'uas' => $n[5],

                'na' => $n[0],

                'sks' => $mk->sks,

                'kelas' => 'A',

                'survey' => true,
            ];
        }

        DB::table('krs')->insert($data);
    }
}