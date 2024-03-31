<?php

namespace App\Imports;

use App\Models\Program;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProgramImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Program([
            'codigo' => $row['codigo'],
            'nombre' => $row['nombre'],
            'sigla' => $row['sigla'],
            'version' => $row['version'],
            'edicion' => $row['edicion'],
            'tipo' => $row['tipo'],
            'modalidad' => $row['modalidad'],
            'fecha_inicio' => $row['fecha_inicio'],
            'fecha_final' => $row['fecha_final'],
        ]);
    }
}
