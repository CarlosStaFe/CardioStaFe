<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        //User::factory()->create([
        //    'name' => 'Test User',
        //    'email' => 'test@example.com',
        //]);
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('123456')
        ]);
        User::create([
            'name' => 'Secretaria',
            'email' => 'secretaria@secretaria.com',
            'password' => bcrypt('123456')
        ]);
        User::create([
            'name' => 'Medico1',
            'email' => 'medico1@medico1.com',
            'password' => bcrypt('123456')
        ]);
        User::create([
            'name' => 'Paciente1',
            'email' => 'paciente1@paciente1.com',
            'password' => bcrypt('123456')
        ]);

    }
}
