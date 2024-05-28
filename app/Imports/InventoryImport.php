<?php

namespace App\Imports;

use App\Constants\ImageDefault;
use App\Models\FixedAsset;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class InventoryImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new FixedAsset([
            'foto' => ImageDefault::INVENTORY,
            'codigo' => $row['codigo'],
            'nombre' => $row['nombre'],
            'tipo' => $row['tipo'],
            'modelo' => $row['modelo'] ?? null,
            'cantidad' => $row['cantidad'] ?? 1,
            'estado' => $row['estado'],
            'descripcion' => $row['descripcion'] ?? null,
            'unidad' => $row['unidad'] ?? null,
        ]);
    }
}
