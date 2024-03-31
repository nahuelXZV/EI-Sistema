<?php

namespace App\Imports;

use App\Constants\ImageDefault;
use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Student([
            'honorifico' => $row['honorifico'],
            'nombre' => $row['nombre'],
            'apellido' => $row['apellido'],
            'foto' => ImageDefault::USER,
            'cedula' => $row['cedula'],
            'expedicion' => $row['expedicion'] ?? null,
            'telefono' => $row['telefono'] ?? null,
            'correo' => $row['correo'],
            'carrera_id' => 1,
            'universidad_id' => 1,
        ]);
    }
}
