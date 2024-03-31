<?php

namespace App\Imports;

use App\Models\Course;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CourseImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Course([
            'nombre' => $row['nombre'],
            'horario' => $row['horario'],
            'modalidad' => $row['modalidad'],
            'fecha_inicio' => $row['fecha_inicio'],
            'fecha_final' => $row['fecha_final'],
        ]);
    }
}
