<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Area;
use App\Models\Cargo;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Cargo::create([
            'nombre' => 'Gerente',
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
        ]);
    }
}
