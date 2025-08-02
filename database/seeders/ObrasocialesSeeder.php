<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ObrasocialesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('obrasociales')->insert([
            ['nombre' => 'NO TIENE', 'telefono' => 'NO BORRAR', 'contacto' => '', 'email' => 'NO BORRAR', 'activo' => 1, 'documentacion' => '', 'observacion' => ''],
        ]);
    }
}
