<?php

namespace App\Services\Academic;

use App\Models\Student;

class StudentService
{
    public function __construct()
    {
    }

    static public function getAll()
    {
        $students = Student::all();
        return $students;
    }

    static public function getAllByNameAndCi($value)
    {
        if ($value == "") return Student::all();
        return Student::where('nombre', 'ILIKE', '%' . strtolower($value) . '%')
            ->orWhere('apellido', 'ILIKE', '%' . strtolower($value) . '%')
            ->orWhere('cedula', 'ILIKE', '%' . strtolower($value) . '%')
            ->get();
    }

    static public function getAllPaginate($attribute, $paginate, $order = "desc")
    {
        $students = Student::where('nombre', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orWhere('apellido', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orWhere('cedula', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orWhere('honorifico', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orderBy('nombre', $order)
            ->paginate($paginate);
        return $students;
    }

    static  public function getOne($id)
    {
        $student = Student::join('career', 'student.carrera_id', '=', 'career.id')
            ->join('university', 'student.universidad_id', '=', 'university.id')
            ->select('student.*', 'career.nombre as carrera', 'university.nombre as universidad')
            ->where('student.id', $id)
            ->first();
        return $student;
    }

    static public function create($data)
    {
        try {
            $new = Student::create($data);
            return $new;
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return false;
        }
    }

    static public function update($data)
    {
        try {
            $student = Student::find($data['id']);
            $student->honorifico = $data['honorifico'] ?? $student->honorifico;
            $student->nombre = $data['nombre'] ?? $student->nombre;
            $student->apellido = $data['apellido'] ?? $student->apellido;
            $student->foto = $data['foto'] ?? $student->foto;
            $student->cedula = $data['cedula'] ?? $student->cedula;
            $student->expedicion = $data['expedicion'] ?? $student->expedicion;
            $student->telefono = $data['telefono'] ?? $student->telefono;
            $student->correo = $data['correo'] ?? $student->correo;
            $student->estado = $data['estado'] ?? $student->estado;
            $student->fecha_inactividad = $data['fecha_inactividad'] ?? $student->fecha_inactividad;
            $student->nro_registro = $data['nro_registro'] ?? $student->nro_registro;
            $student->nacionalidad = $data['nacionalidad'] ?? $student->nacionalidad;
            $student->sexo = $data['sexo'] ?? $student->sexo;
            $student->carrera_id = $data['carrera_id'] ?? $student->carrera_id;
            $student->universidad_id = $data['universidad_id'] ?? $student->universidad_id;
            $student->save();
            return $student;
        } catch (\Throwable $th) {
            return false;
        }
    }

    static  public function delete($id)
    {
        try {
            $student = Student::find($id);
            $student->delete();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
};
