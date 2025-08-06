<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class SecretariasSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('secretarias')->insert([
            ['apel_nombres' => 'DURÉ CLAUDIA', 'telefono' => '9', 'domicilio' => 'CATAMARCA 3393', 'user_id' => 2],
        ]);
    }
}
