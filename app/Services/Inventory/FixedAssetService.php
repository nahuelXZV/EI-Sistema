<?php

namespace App\Services\Inventory;

use App\Models\FixedAsset;

class FixedAssetService
{
    public function __construct()
    {
    }

    static public function getAll()
    {
        $inventories = FixedAsset::leftJoin('users', 'users.id', '=', 'fixed_asset.encargado_id')
            ->leftJoin('area', 'area.id', '=', 'fixed_asset.area_id')
            ->leftJoin('units', 'units.id', '=', 'fixed_asset.unidad_id')
            ->select('fixed_asset.*', 'users.nombre as name_user', 'users.apellido as lastname_user', 'area.nombre as area', 'units.nombre as unidad_nombre')
            ->get();
        return $inventories;
    }

    static public function getAllPaginate($attribute, $paginate, $state, $unit, $order = "desc")
    {
        $query = FixedAsset::query()
            ->leftJoin('units', 'fixed_asset.unidad_id', '=', 'units.id')
            ->leftJoin('users', 'fixed_asset.encargado_id', '=', 'users.id')
            ->leftJoin('area', 'fixed_asset.area_id', '=', 'area.id')
            ->select('fixed_asset.*', 'units.nombre as unidad_nombre', 'users.nombre as name_user', 'users.apellido as lastname_user', 'area.nombre as area');

        if ($unit != 0 && $state != "") {
            $query->where('fixed_asset.estado', '=', $state)
                ->where('fixed_asset.unidad_id', '=', $unit);
        } elseif ($unit != 0) {
            $query->where('fixed_asset.unidad_id', '=', $unit);
        } elseif ($state != "") {
            $query->where('fixed_asset.estado', '=', $state);
        }
        $query->where(function ($q) use ($attribute) {
            $q->orWhere('fixed_asset.nombre', 'ILIKE', '%' . strtolower($attribute) . '%')
                ->orWhere('fixed_asset.codigo', 'ILIKE', '%' . strtolower($attribute) . '%');
        });
        return $query->orderBy('fixed_asset.nombre', $order)
            ->paginate($paginate);
    }

    static public function getAllByUnitAndState($state, $unit, $order = "desc")
    {
        $query = FixedAsset::query()
            ->leftJoin('units', 'fixed_asset.unidad_id', '=', 'units.id')
            ->leftJoin('users', 'fixed_asset.encargado_id', '=', 'users.id')
            ->leftJoin('area', 'fixed_asset.area_id', '=', 'area.id')
            ->select('fixed_asset.*', 'units.nombre as unidad_nombre', 'users.nombre as name_user', 'users.apellido as lastname_user', 'area.nombre as area');

        if ($unit != 0 && $state != "") {
            $query->where('fixed_asset.estado', '=', $state)
                ->where('fixed_asset.unidad_id', '=', $unit);
        } elseif ($unit != 0) {
            $query->where('fixed_asset.unidad_id', '=', $unit);
        } elseif ($state != "") {
            $query->where('fixed_asset.estado', '=', $state);
        }
        return $query->orderBy('fixed_asset.nombre', $order)->get();
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
            ->leftJoin('units', 'units.id', '=', 'fixed_asset.unidad_id')
            ->select('fixed_asset.*', 'users.nombre as name_user', 'users.apellido as lastname_user', 'area.nombre as area', 'units.nombre as unidad')
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
            $inventory->unidad_id = $data['unidad_id'] ?? $inventory->unidad_id;
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
