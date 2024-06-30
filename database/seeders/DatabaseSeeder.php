<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\Career;
use App\Models\Cargo;
use App\Models\Teacher;
use App\Models\University;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        activity()->withoutLogs(function () {
            $this->call([RoleSeeder::class]);

            Cargo::create([
                'nombre' => 'TI',
            ]);

            Area::create([
                'nombre' => 'Administración',
            ]);

            User::create([
                'nombre' => 'Test User',
                'apellido' => 'Test User',
                'email' => 'example@live.com',
                'password' => bcrypt('12345678'),
                'cargo_id' => 1,
                'area_id' => 1,
            ])->assignRole('Administrador');

            Teacher::create([
                'honorifico' => 'Lic.',
                'nombre' => 'Test',
                'apellido' => 'User',
                'foto' => 'link.com',
                'cv' => 'link.com',
                'cedula' => '1234567890',
                'expedicion' => 'LPZ',
                'correo' => 'correo@live.com',
                'telefono' => '4655455',
            ]);

            Career::create([
                'id' => 1,
                'nombre' =>   'Sin Especificar',
            ]);

            University::create([
                'id' => 1,
                'nombre' => 'Sin Especificar',
            ]);

            // Program::create([]);

            // Module::create([]);
        });
    }
}
