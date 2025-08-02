<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ObrasocialesSeeder extends Seeder
{
    public function run(): void
    {
        // Ruta del archivo JSON
        $json = File::get(storage_path('app/obrassociales.json'));

        // Decodificar el JSON a un array
        $obrasociales = json_decode($json, true);

        // Dividir los datos en lotes de 500 registros
        $chunks = array_chunk($obrasociales, 500);

        foreach ($chunks as $lote) {
            foreach ($lote as $obra) {
                $nombre = $obra['Nombre'] ?? 'X';
                $telefono = $obra['Telefono'] ?? '-';
                $contacto = '-';
                $email = $obra['Email'] ?? '@';
                $activo = 1;
                $documentacion = '-';
                $observacion = $obra['Obs'] ?? '';
            
                DB::table('obrasociales')->insert([
                    'nombre'          => $nombre,
                    'telefono'        => $telefono,
                    'contacto'        => $contacto,
                    'email'           => $email,
                    'activo'          => $activo,
                    'documentacion'   => $documentacion,
                    'observacion'     => $observacion,
                ]);
            }
        }
        DB::table('obrasociales')->insert([
            ['nombre' => 'NO TIENE', 'telefono' => 'NO BORRAR', 'contacto' => '', 'email' => 'NO BORRAR', 'activo' => 1, 'documentacion' => '', 'observacion' => ''],
        ]);

    }
}
