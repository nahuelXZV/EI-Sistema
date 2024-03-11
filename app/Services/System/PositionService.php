<?php

namespace App\Services\System;

use App\Models\Cargo;

class PositionService
{
    public function __construct()
    {
    }

    static public function getAll()
    {
        $positions = Cargo::all();
        return $positions;
    }

    static public function getAllPaginate($attribute, $paginate, $order = "desc")
    {
        $positions = Cargo::where('nombre', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orderBy('id', $order)
            ->paginate($paginate);
        return $positions;
    }

    static  public function getOne($id)
    {
        $position = Cargo::find($id);
        return $position;
    }

    static public function create($data)
    {
        try {
            $new = Cargo::create([
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
            $position = Cargo::find($data['id']);
            $position->nombre = $data['nombre'];
            $position->save();
            return $position;
        } catch (\Throwable $th) {
            return false;
        }
    }

    static  public function delete($id)
    {
        try {
            $position = Cargo::find($id);
            $position->delete();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
};
