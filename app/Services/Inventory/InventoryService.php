<?php

namespace App\Services\Inventory;

use App\Models\FixedAsset;

class InventoryService
{
    public function __construct()
    {
    }

    static public function getAll()
    {
        $inventories = FixedAsset::all();
        return $inventories;
    }

    static public function getAllPaginate($attribute, $paginate, $order = "desc")
    {
        $inventories = FixedAsset::where('nombre', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orWhere('codigo', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orWhere('tipo', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orWhere('estado', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orderBy('id', $order)
            ->paginate($paginate);
        return $inventories;
    }

    static  public function getOne($id)
    {
        $inventory = FixedAsset::find($id);
        return $inventory;
    }

    static public function getOneAll($id)
    {
        $inventory = FixedAsset::leftJoin('users', 'users.id', '=', 'fixed_asset.encargado_id')
            ->leftJoin('area', 'area.id', '=', 'fixed_asset.area_id')
            ->select('fixed_asset.*', 'users.nombre as name_user', 'users.apellido as lastname_user', 'area.nombre as area')
            ->where('fixed_asset.id', $id)
            ->first();

        return $inventory;
    }

    static public function create($data)
    {
        try {
            $new = FixedAsset::create($data);
            return $new;
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return false;
        }
    }

    static public function update($data)
    {
        try {
            $inventory = FixedAsset::find($data['id']);
            $inventory->foto = $data['foto'] ?? $inventory->foto;
            $inventory->codigo = $data['codigo'] ?? $inventory->codigo;
            $inventory->nombre = $data['nombre'] ?? $inventory->nombre;
            $inventory->tipo = $data['tipo'] ?? $inventory->tipo;
            $inventory->modelo = $data['modelo'] ?? $inventory->modelo;
            $inventory->cantidad = $data['cantidad'] ?? $inventory->cantidad;
            $inventory->estado = $data['estado'] ?? $inventory->estado;
            $inventory->descripcion = $data['descripcion'] ?? $inventory->descripcion;
            $inventory->unidad = $data['unidad'] ?? $inventory->unidad;
            $inventory->encargado_id = $data['encargado_id'] ?? $inventory->encargado_id;
            $inventory->area_id = $data['area_id'] ?? $inventory->area_id;
            $inventory->save();
            return $inventory;
        } catch (\Throwable $th) {
            return false;
        }
    }

    static  public function delete($id)
    {
        try {
            $inventory = FixedAsset::find($id);
            $inventory->delete();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
};
