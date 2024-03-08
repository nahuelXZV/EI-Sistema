<?php

namespace App\Services\System;

use App\Models\Area;
use Spatie\Permission\Models\Permission;

class AreaService
{
    public function __construct()
    {
    }

    static public function getAll()
    {
        $areas = Area::all();
        return $areas;
    }

    static public function getAllPaginate($attribute, $paginate, $order = "desc")
    {
        $areas = Area::where('nombre', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orderBy('id', $order)
            ->paginate($paginate);
        return $areas;
    }

    static  public function getOne($id)
    {
        $area = Area::find($id);
        return $area;
    }

    static public function create($data)
    {
        try {
            $new = Area::create([
                'nombre' => $data['nombre'],
            ]);
            return $new;
        } catch (\Throwable $th) {
            return false;
        }
    }

    static public function update($data)
    {
        try {
            $area = Area::find($data['id']);
            $area->nombre = $data['nombre'];
            $area->save();
            return $area;
        } catch (\Throwable $th) {
            return false;
        }
    }

    static  public function delete($id)
    {
        try {
            $area = Area::find($id);
            $area->delete();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
};
