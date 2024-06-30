<?php

namespace App\Imports;

use App\Constants\ImageDefault;
use App\Models\Inventory;
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
        if (!isset($row['nombre'])) {
            return null;
        }
        return new Inventory([
            'foto' => ImageDefault::INVENTORY,
            'codigo_partida' => $row['codigo_partida'],
            'codigo_catalogo' => $row['codigo_catalogo'],
            'nombre' => $row['nombre'],
            'tipo' => $row['tipo'],
            'cantidad' => $row['cantidad'] ?? 1,
            'estado' => "Sin Estado",
            'unidad_medida' => $row['unidad_medida'] ?? null,
            'descripcion' => $row['descripcion'] ?? '',
        ]);
    }
}
