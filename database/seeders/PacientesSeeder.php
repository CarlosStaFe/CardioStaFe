<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class PacientesSeeder extends Seeder
{
    public function run(): void
    {
        // Ruta del archivo JSON
        $json = File::get(storage_path('app/pacientes.json'));

        // Decodificar el JSON a un array
        $pacientes = json_decode($json, true);

        // Dividir los datos en lotes de 500 registros
        $chunks = array_chunk($pacientes, 500);

        foreach ($chunks as $chunk) {
            $datos = [];
            $numero = 0;
            foreach ($chunk as $paciente) {
                $num_documento = $paciente['NumeroDoc'] ?? '';

                // Si ya existe en el lote, lo salta
                //if (in_array($num_documento, $documentos)) {
                //    continue;
                //}

                // Verifica si el número de documento ya existe en la base de datos
                if (DB::table('pacientes')->where('num_documento', $num_documento)->exists()) {
                    while (true) {
                        $numero++;
                        echo "Verificando número de documento: $numero\n";

                        $existe = DB::table('pacientes')->where('num_documento', $numero)->exists();

                        if (!$existe) {
                            DB::table('pacientes')->insert([
                                'apel_nombres'    => $paciente['ApelNombres'] ?? 'X',
                                'nacimiento'      => $paciente['FechaNacim'] ?? '1900-01-01',
                                'sexo'            => $paciente['Sexo'] ?? 'M',
                                'tipo_documento'  => $paciente['TipoDoc'] ?? 'DNI',
                                'num_documento'   => $numero,
                                'domicilio'       => $paciente['Domicilio'] ?? '-',
                                'cod_postal_id'   => $paciente['CodPostal'] ?? 1,
                                'telefono'        => $paciente['Telefono'] ?? '-',
                                'email'           => $paciente['Email'] ?? '@',
                                'obra_social_id'  => 1,
                                'num_afiliado'    => $paciente['Afiliado'] ?? '1',
                                'observacion'     => $paciente['Obs'] ?? '',
                            ]);
                            break;
                        }
                    }
                }else {
                    DB::table('pacientes')->insert([
                        'apel_nombres'    => $paciente['ApelNombres'] ?? 'X',
                        'nacimiento'      => $paciente['FechaNacim'] ?? '1900-01-01',
                        'sexo'            => $paciente['Sexo'] ?? 'M',
                        'tipo_documento'  => $paciente['TipoDoc'] ?? 'DNI',
                        'num_documento'   => $num_documento,
                        'domicilio'       => $paciente['Domicilio'] ?? '-',
                        'cod_postal_id'   => $paciente['CodPostal'] ?? 1,
                        'telefono'        => $paciente['Telefono'] ?? '-',
                        'email'           => $paciente['Email'] ?? '@',
                        'obra_social_id'  => 1,
                        'num_afiliado'    => $paciente['Afiliado'] ?? '1',
                        'observacion'     => $paciente['Obs'] ?? '',
                    ]);
                }
            }
        }
    }
}
