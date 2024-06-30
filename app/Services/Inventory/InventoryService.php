<?php

namespace App\Services\Inventory;

use App\Models\Inventory;

class InventoryService
{
    public function __construct()
    {
    }

    static public function getAll()
    {
        $inventories = Inventory::all();
        return $inventories;
    }

    static public function getAllPaginate($attribute, $paginate, $order = "desc")
    {
        $inventories = Inventory::where('nombre', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orWhere('codigo_partida', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orWhere('codigo_catalogo', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orWhere('tipo', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orWhere('estado', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orderBy('id', $order)
            ->paginate($paginate);
        return $inventories;
    }

    static  public function getOne($id)
    {
        $inventory = Inventory::find($id);
        return $inventory;
    }

    static public function create($data)
    {
        try {
            $new = Inventory::create($data);
            return $new;
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return false;
        }
    }

    static public function update($data)
    {
        try {
            $inventory = Inventory::find($data['id']);
            $inventory->foto = $data['foto'] ?? $inventory->foto;
            $inventory->codigo_partida = $data['codigo_partida'] ?? $inventory->codigo_partida;
            $inventory->codigo_catalogo = $data['codigo_catalogo'] ?? $inventory->codigo_catalogo;
            $inventory->nombre = $data['nombre'] ?? $inventory->nombre;
            $inventory->descripcion = $data['descripcion'] ?? $inventory->descripcion;
            $inventory->tipo = $data['tipo'] ?? $inventory->tipo;
            $inventory->cantidad = $data['cantidad'] ?? $inventory->cantidad;
            $inventory->estado = $data['estado'] ?? $inventory->estado;
            $inventory->unidad_medida = $data['unidad_medida'] ?? $inventory->unidad_medida;
            $inventory->save();
            return $inventory;
        } catch (\Throwable $th) {
            return false;
        }
    }

    static  public function delete($id)
    {
        try {
            $inventory = Inventory::find($id);
            $inventory->delete();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
};
