<?php

namespace App\Services\Academic;

use App\Models\AreaProfession;

class AreaProfessionService
{
    public function __construct()
    {
    }

    static public function getAll()
    {
        $area_professions = AreaProfession::all();
        return $area_professions;
    }

    static public function getAllPaginate($attribute, $paginate, $order = "desc")
    {
        $area_professions = AreaProfession::where('nombre', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orderBy('id', $order)
            ->paginate($paginate);
        return $area_professions;
    }
    static  public function getOne($id)
    {
        $area_profession = AreaProfession::find($id);
        return $area_profession;
    }

    static public function create($data)
    {
        try {
            $new = AreaProfession::create([
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
            $area_profession = AreaProfession::find($data['id']);
            $area_profession->nombre = $data['nombre'];
            $area_profession->save();
            return $area_profession;
        } catch (\Throwable $th) {
            return false;
        }
    }

    static  public function delete($id)
    {
        try {
            $area_profession = AreaProfession::find($id);
            $area_profession->delete();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
};
