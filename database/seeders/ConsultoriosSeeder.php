<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ConsultoriosSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('consultorios')->insert([
            ['nombre' => 'SANTA FE', 'numero' => '1', 'direccion' => '', 'telefono' =>'342123', 'observacion' => ''],
            ['nombre' => 'PARANÁ', 'numero' => '2', 'direccion' => '', 'telefono' =>'342123', 'observacion' => ''],
            ['nombre' => 'RAFAELA', 'numero' => '3', 'direccion' => '', 'telefono' =>'342123', 'observacion' => ''],
            ['nombre' => 'GALVEZ', 'numero' => '4', 'direccion' => '', 'telefono' =>'342123', 'observacion' => ''],
        ]);
    }
}
