<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MedicosSeeder extends Seeder
{
    public function run(): void
    {
        $usuarios = [
        ['name' => 'PASTORE CARLOS', 'email' => 'pastore@carlos.com', 'password' => Hash::make('12345678')],
        ['name' => 'PASTORE ENZO', 'email' => 'sabalero@colon.com', 'password' => Hash::make('12345678')],
        ['name' => 'PASTORE CONSTANZA', 'email' => 'constanza@pastore.com', 'password' => Hash::make('12345678')],
        ['name' => 'WEIDMANN WALTER', 'email' => 'weidman@walter.com', 'password' => Hash::make('12345678')],
        ];

        foreach ($usuarios as $usuario) {
            $userId = DB::table('users')->insertGetId($usuario);

            // Crear médicos asociados a los usuarios
            DB::table('medicos')->insert([
                'apel_nombres' => $usuario['name'],
                'matricula' => fake()->unique()->numerify('####'),
                'telefono' => fake()->phoneNumber(),
                'especialidad' => 'cardiología',
                'email' => $usuario['email'],
                'activo' => 'S',
                'user_id' => $userId,
            ]);
        }
    }
}

//php artisan db:seed --class=MedicosSeeder
//php artisan db:seed