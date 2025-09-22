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
        ['name' => 'PASTORE CARLOS', 'email' => 'capastore@gmail.com', 'password' => Hash::make('cardil3373')],
        ['name' => 'PASTORE ENZO', 'email' => 'sabalero@colon.com', 'password' => Hash::make('12345678')],
        ['name' => 'PASTORE CONSTANZA', 'email' => 'pastoreconstanza@gmail.com', 'password' => Hash::make('felicitas')],
        ['name' => 'WEIDMANN WALTER', 'email' => 'weidman@walter.com', 'password' => Hash::make('12345678')],
        ];

        foreach ($usuarios as $usuario) {
            // Crear usuario y asignar rol
            $user = new \App\Models\User();
            $user->name = $usuario['name'];
            $user->email = $usuario['email'];
            $user->password = $usuario['password'];
            $user->save();
            $user->assignRole('medico');

            // Crear médicos asociados a los usuarios
            DB::table('medicos')->insert([
                'apel_nombres' => $usuario['name'],
                'matricula' => fake()->unique()->numerify('####'),
                'telefono' => fake()->phoneNumber(),
                'especialidad' => 'cardiología',
                'email' => $usuario['email'],
                'activo' => 'S',
                'user_id' => $user->id,
            ]);
        }
    }
}

//php artisan db:seed --class=MedicosSeeder
//php artisan db:seed