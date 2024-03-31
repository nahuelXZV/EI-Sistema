<?php

namespace App\Services\Academic;

use App\Models\Course;

class CourseService
{
    public function __construct()
    {
    }

    static public function getAll()
    {
        $courses = Course::all();
        return $courses;
    }

    static public function getAllPaginate($attribute, $paginate, $order = "desc")
    {
        $courses = Course::where('nombre', 'ILIKE', '%' . strtolower($attribute) . '%')
        ->orWhere('modalidad', 'ILIKE', '%' . strtolower($attribute) . '%')
        ->orderBy('id', $order)
            ->paginate($paginate);
        return $courses;
    }

    static  public function getOne($id)
    {
        $course = Course::find($id);
        return $course;
    }

    static public function create($data)
    {
        try {
            $new = Course::create($data);
            return $new;
        } catch (\Throwable $th) {
            return false;
        }
    }

    static public function update($data)
    {
        try {
            $course = Course::find($data['id']);
            $course->nombre = $data['nombre'] ?? $course->nombre;
            $course->horario = $data['horario'] ?? $course->horario;
            $course->hrs_academicas = $data['hrs_academicas'] ?? $course->hrs_academicas;
            $course->costo = $data['costo'] ?? $course->costo;
            $course->modalidad = $data['modalidad'] ?? $course->modalidad;
            $course->fecha_inicio = $data['fecha_inicio'] ?? $course->fecha_inicio;
            $course->fecha_final = $data['fecha_final'] ?? $course->fecha_final;
            $course->docente_id = $data['docente_id'] ?? $course->docente_id;
            $course->save();
            return $course;
        } catch (\Throwable $th) {
            return false;
        }
    }

    static  public function delete($id)
    {
        try {
            $course = Course::find($id);
            $course->delete();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
};
