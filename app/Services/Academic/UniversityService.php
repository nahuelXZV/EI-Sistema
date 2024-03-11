<?php

namespace App\Services\Academic;

use App\Models\University;

class UniversityService
{
    public function __construct()
    {
    }

    static public function getAll()
    {
        $universities = University::all();
        return $universities;
    }

    static public function getAllPaginate($attribute, $paginate, $order = "desc")
    {
        $universities = University::where('nombre', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orderBy('id', $order)
            ->paginate($paginate);
        return $universities;
    }

    static  public function getOne($id)
    {
        $university = University::find($id);
        return $university;
    }

    static public function create($data)
    {
        try {
            $new = University::create([
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
            $university = University::find($data['id']);
            $university->nombre = $data['nombre'];
            $university->save();
            return $university;
        } catch (\Throwable $th) {
            return false;
        }
    }

    static  public function delete($id)
    {
        try {
            $university = University::find($id);
            $university->delete();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
};
