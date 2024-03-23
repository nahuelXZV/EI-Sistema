<?php

namespace App\Services\Academic;

use App\Models\RegistrationRequirement;

class RegistrationRequirementService
{
    public function __construct()
    {
    }

    static public function getAll()
    {
        $requirement = RegistrationRequirement::all();
        return $requirement;
    }

    static public function getAllPaginate($attribute, $paginate, $order = "desc")
    {
        $requirement = RegistrationRequirement::where('nombre', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orderBy('id', $order)
            ->paginate($paginate);
        return $requirement;
    }

    static  public function getOne($id)
    {
        $requirement = RegistrationRequirement::find($id);
        return $requirement;
    }

    static public function create($data)
    {
        try {
            $new = RegistrationRequirement::create([
                'nombre' => $data['nombre'],
                'importancia' => $data['importancia'],
            ]);
            return $new;
        } catch (\Throwable $th) {
            return false;
        }
    }

    static public function update($data)
    {
        try {
            $requirement = RegistrationRequirement::find($data['id']);
            $requirement->nombre = $data['nombre'];
            $requirement->importancia = $data['importancia'];
            $requirement->save();
            return $requirement;
        } catch (\Throwable $th) {
            return false;
        }
    }

    static  public function delete($id)
    {
        try {
            $requirement = RegistrationRequirement::find($id);
            $requirement->delete();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
};
