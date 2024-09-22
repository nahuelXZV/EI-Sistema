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
            $new = Leader::create($data);
            return $new;
        } catch (\Throwable $th) {
            return false;
        }
    }

    static public function update($data)
    {
        try {
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
};
