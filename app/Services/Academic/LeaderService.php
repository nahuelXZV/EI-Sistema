<?php

namespace App\Services\Academic;

use App\Models\Leader;

class LeaderService
{
    public function __construct() {}

    static public function getAll()
    {
        $leaders = Leader::all();
        return $leaders;
    }

    static public function getAllPaginate($attribute, $paginate, $order = "desc")
    {
        $leaders = Leader::where('nombre', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orWhere('apellido', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orderBy('id', $order)
            ->paginate($paginate);
        return $leaders;
    }

    static  public function getOne($id)
    {
        $leader = Leader::find($id);
        return $leader;
    }

    static public function create($data)
    {
        try {
            $active = self::verifyActive($data['institucion'], $data['cargo']);
            if ($active) $active->update(['activo' => false]);
            $new = Leader::create($data);
            return $new;
        } catch (\Throwable $th) {
            return false;
        }
    }

    static public function update($data)
    {
        try {
            $active = self::verifyActive($data['institucion'], $data['cargo']);
            if ($active) $active->update(['activo' => false]);
            $leader = Leader::find($data['id']);
            $leader->update($data);
            return $leader;
        } catch (\Throwable $th) {
            return false;
        }
    }

    static  public function delete($id)
    {
        try {
            $leader = Leader::find($id);
            $leader->delete();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    static public function verifyActive($institution, $position)
    {
        $leader = Leader::where('institucion', $institution)
            ->where('cargo', $position)
            ->where('activo', true)
            ->first();
        return $leader;
    }
};
