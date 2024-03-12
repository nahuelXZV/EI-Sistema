<?php

namespace App\Services\Academic;

use App\Models\Career;

class CareerService
{
    public function __construct()
    {
    }

    static public function getAll()
    {
        $careers = Career::all();
        return $careers;
    }

    static public function getAllPaginate($attribute, $paginate, $order = "desc")
    {
        $careers = Career::where('nombre', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orderBy('id', $order)
            ->paginate($paginate);
        return $careers;
    }

    static  public function getOne($id)
    {
        $career = Career::find($id);
        return $career;
    }

    static public function create($data)
    {
        try {
            $new = Career::create([
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
            $career = Career::find($data['id']);
            $career->nombre = $data['nombre'];
            $career->save();
            return $career;
        } catch (\Throwable $th) {
            return false;
        }
    }

    static  public function delete($id)
    {
        try {
            $career = Career::find($id);
            $career->delete();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
};
