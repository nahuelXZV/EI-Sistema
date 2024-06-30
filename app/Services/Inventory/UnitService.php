<?php

namespace App\Services\Inventory;

use App\Models\Unit;

class UnitService
{
    public function __construct()
    {
    }

    static public function getAll()
    {
        $units = Unit::all();
        return $units;
    }

    static public function getAllPaginate($attribute, $paginate, $order = "desc")
    {
        $units = Unit::where('nombre', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orderBy('id', $order)
            ->paginate($paginate);
        return $units;
    }

    static public function getOne($id)
    {
        $unit = Unit::find($id);
        return $unit;
    }

    static public function create($data)
    {
        try {
            $new = Unit::create($data);
            return $new;
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return false;
        }
    }

    static public function update($data)
    {
        try {
            $unit = Unit::find($data['id']);
            $unit->nombre = $data['nombre'] ?? $unit->nombre;
            $unit->save();
            return $unit;
        } catch (\Throwable $th) {
            return false;
        }
    }

    static  public function delete($id)
    {
        try {
            $unit = Unit::find($id);
            $unit->delete();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
};
