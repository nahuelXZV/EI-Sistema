<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class Inventory  implements ToModel, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function model(array $row)
    {
        return new Inventory([
            'codigo' => $row['codigo'],
            'nombre' => $row['nombre'],
            'tipo' => $row['tipo'],
            'modelo' => $row['modelo'],
            'cantidad' => $row['cantidad'],
            'estado' => $row['estado'],
            'descripcion' => $row['descripcion'],
            'unidad' => $row['unidad'],
            'fecha_final' => $row['fecha_final'],
        ]);
    }
}
