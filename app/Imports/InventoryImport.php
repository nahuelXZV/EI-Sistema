<?php

namespace App\Imports;

use App\Constants\ImageDefault;
use App\Models\Inventory;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class InventoryImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        if (!isset($row['nombre'])) {
            return null;
        }
        $cantidad_contenedor = $row['cantidad_contenedor'] ?? 1;
        $unidades_contenedor = $row['unidades_contenedor'] ?? 1;
        $total_unidades = $cantidad_contenedor * $unidades_contenedor;
        return new Inventory([
            'foto' => ImageDefault::INVENTORY,
            'codigo_partida' => $row['codigo_partida'],
            'codigo_catalogo' => $row['codigo_catalogo'],
            'nombre' => $row['nombre'],
            'tipo' => $row['tipo'],
            'estado' => "Sin Estado",
            'descripcion' => $row['descripcion'],
            'cantidad_contenedor' => $cantidad_contenedor,
            'unidades_contenedor' => $unidades_contenedor,
            'total_unidades' => $total_unidades

        ]);
    }
}
