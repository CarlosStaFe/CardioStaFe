<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class PracticasSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('practicas')->insert([
            ['nombre' => 'CONSULTA', 'observacion' => ''],
            ['nombre' => 'CONSULTA + ELECTROCARDIOGRAMA', 'observacion' => ''],
            ['nombre' => 'ECOCARDIOGRAMA DOPPLER COLOR PEDIÁTRICO', 'observacion' => ''],
        ]);
    }
}
