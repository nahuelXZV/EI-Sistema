<?php

namespace App\Services\Academic;

use App\Models\Teacher;

class TeacherService
{
    public function __construct()
    {
    }

    static public function getAll()
    {
        $teachers = Teacher::all();
        return $teachers;
    }

    static public function getAllByNameAndCi($value)
    {
        if ($value == "") return Teacher::all();
        return Teacher::where('nombre', 'ILIKE', '%' . strtolower($value) . '%')
            ->orWhere('apellido', 'ILIKE', '%' . strtolower($value) . '%')
            ->orWhere('cedula', 'ILIKE', '%' . strtolower($value) . '%')
            ->get();
    }

    static public function getAllPaginate($attribute, $paginate, $order = "desc")
    {
        $teachers = Teacher::where('nombre', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orWhere('apellido', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orWhere('cedula', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orderBy('id', $order)
            ->paginate($paginate);
        return $teachers;
    }

    static  public function getOne($id)
    {
        $teacher = Teacher::find($id);
        return $teacher;
    }

    static public function create($data)
    {
        try {
            $new = Teacher::create($data);
            return $new;
        } catch (\Throwable $th) {
            return false;
        }
    }

    static public function update($data)
    {
        try {
            $teacher = Teacher::find($data['id']);
            $teacher->honorifico = $data['honorifico'] ?? $teacher->honorifico;
            $teacher->nombre = $data['nombre'] ?? $teacher->nombre;
            $teacher->apellido = $data['apellido'] ?? $teacher->apellido;
            $teacher->foto = $data['foto'] ?? $teacher->foto;
            $teacher->cv = $data['cv'] ?? $teacher->cv;
            $teacher->cedula = $data['cedula'] ?? $teacher->cedula;
            $teacher->expedicion = $data['expedicion'] ?? $teacher->expedicion;
            $teacher->telefono = $data['telefono'] ?? $teacher->telefono;
            $teacher->correo = $data['correo'] ?? $teacher->correo;
            $teacher->factura = $data['factura'] ?? $teacher->factura;
            $teacher->save();
            return $teacher;
        } catch (\Throwable $th) {
            return false;
        }
    }

    static  public function delete($id)
    {
        try {
            $teacher = Teacher::find($id);
            $teacher->delete();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
};
