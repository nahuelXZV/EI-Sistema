<?php

namespace App\Imports;

use App\Constants\ImageDefault;
use App\Models\Teacher;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TeacherImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Teacher([
            'honorifico' => $row['honorifico'],
            'nombre' => $row['nombre'],
            'apellido' => $row['apellido'],
            'foto' => ImageDefault::USER,
            'cedula' => $row['cedula'],
            'expedicion' => $row['expedicion'],
            'telefono' => $row['telefono'] ?? null,
            'correo' => $row['correo'] ?? null,
            'factura' => false,
        ]);
    }
}
