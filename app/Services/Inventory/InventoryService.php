<?php

namespace App\Services\Inventory;

use App\Constants\InventoryFilter;
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

    static public function getAllPaginate($attribute, $paginate, $filter, $order = "desc")
    {
        if ($filter == InventoryFilter::STOCK_MAYOR_CERO) {

            return Inventory::where('total_unidades', '>', 0)
                ->where(function ($query) use ($attribute) {
                    $query->where('nombre', 'ILIKE', '%' . strtolower($attribute) . '%')
                        ->orWhere('codigo_partida', 'ILIKE', '%' . strtolower($attribute) . '%')
                        ->orWhere('codigo_catalogo', 'ILIKE', '%' . strtolower($attribute) . '%');
                })
                ->orderBy('nombre', $order)
                ->paginate($paginate);
        }
        if ($filter == InventoryFilter::STOCK_CERO) {

            return Inventory::where('total_unidades', 0)
                ->where(function ($query) use ($attribute) {
                    $query->where('nombre', 'ILIKE', '%' . strtolower($attribute) . '%')
                        ->orWhere('codigo_partida', 'ILIKE', '%' . strtolower($attribute) . '%')
                        ->orWhere('codigo_catalogo', 'ILIKE', '%' . strtolower($attribute) . '%');
                })
                ->orderBy('nombre', $order)
                ->paginate($paginate);
        }

        return Inventory::where('nombre', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orWhere('codigo_partida', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orWhere('codigo_catalogo', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orderBy('nombre', $order)
            ->paginate($paginate);
    }

    static public function getAllExport($filter, $order = "desc")
    {
        if ($filter == InventoryFilter::STOCK_MAYOR_CERO) {

            return Inventory::where('total_unidades', '>', 0)
                ->orderBy('nombre', $order)
                ->get();
        }
        if ($filter == InventoryFilter::STOCK_CERO) {

            return Inventory::where('total_unidades', 0)
                ->orderBy('nombre', $order)
                ->get();
        }

        return Inventory::orderBy('nombre', $order)
            ->get();
    }

    static public function geAllQuantitiesGreaterZero($search, $arrayIdInventoriesExcept)
    {
        return Inventory::where('total_unidades', '>', 0)
            ->whereNotIn('id', $arrayIdInventoriesExcept)
            ->where(function ($query) use ($search) {
                $query->where('nombre', 'ILIKE', '%' . strtolower($search) . '%')
                    ->orWhere('codigo_partida', 'ILIKE', '%' . strtolower($search) . '%')
                    ->orWhere('codigo_catalogo', 'ILIKE', '%' . strtolower($search) . '%');
            })
            ->orderBy('nombre', 'asc')
            ->get();
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
            $inventory->update($data);
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
