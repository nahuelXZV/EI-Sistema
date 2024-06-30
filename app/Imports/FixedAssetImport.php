<?php

namespace App\Imports;

use App\Models\FixedAsset;

use App\Constants\ImageDefault;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class FixedAssetImport implements ToModel, WithHeadingRow
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
        return new FixedAsset([
            'foto' => ImageDefault::INVENTORY,
            'codigo' => $row['codigo'],
            'nombre' => $row['nombre'],
            'tipo' => $row['tipo'],
            'modelo' => $row['modelo'] ?? null,
            'cantidad' => $row['cantidad'] ?? 1,
            'estado' => $row['estado'],
            'descripcion' => $row['descripcion'] ?? null,
            'unidad_id' => +$row['unidad'],
        ]);
        // return $fixed_asset;
    }
}
