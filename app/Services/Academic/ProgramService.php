<?php

namespace App\Services\Academic;

use App\Models\Program;

class ProgramService
{
    public function __construct() {}
    static public function getAll()
    {
        $programs = Program::all();
        return $programs;
    }

    // static public function getAll

    static public function getAllFilterByInitialsAndName($value)
    {
        if ($value == "") return Program::all();
        return Program::where('sigla', 'ILIKE', '%' . strtolower($value) . '%')
            ->orWhere('nombre', 'ILIKE', '%' . strtolower($value) . '%')
            ->get();
    }

    static public function getAllPaginate($attribute, $paginate, $order = "desc")
    {
        $programs = Program::where('nombre', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orWhere('codigo', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orWhere('modalidad', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orderBy('nombre', $order)
            ->paginate($paginate);
        return $programs;
    }

    static public function getAllProgramOfferPaginate($attribute, $paginate, $order = "desc")
    {
        $programs = Program::where('esta_en_oferta', true)
            ->when($attribute, function ($query, $attribute) {
                $query->where(function ($q) use ($attribute) {
                    $q->where('nombre', 'ILIKE', "%{$attribute}%")
                        ->orWhere('codigo', 'ILIKE', "%{$attribute}%")
                        ->orWhere('modalidad', 'ILIKE', "%{$attribute}%");
                });
            })
            ->orderBy('nombre', $order)
            ->paginate($paginate);

        return $programs;
    }

    static public function getProgramsByStudent($id)
    {
        $programs = Program::join('student_program', 'program.id', '=', 'student_program.program_id')
            ->where('student_program.student_id', $id)
            ->select('program.*')
            ->get();
        return $programs;
    }

    static  public function getOne($id)
    {
        $program = Program::find($id);
        return $program;
    }

    static public function create($data)
    {
        try {
            $new = Program::create($data);
            return $new;
        } catch (\Throwable $th) {
            return false;
        }
    }

    static public function update($data)
    {
        try {
            $program = Program::find($data['id']);
            $program->nombre = $data['nombre'] ?? $program->nombre;
            $program->codigo = $data['codigo'] ?? $program->codigo;
            $program->sigla = $data['sigla'] ?? $program->sigla;
            $program->version = $data['version'] ?? $program->version;
            $program->edicion = $data['edicion'] ?? $program->edicion;
            $program->tipo = $data['tipo'] ?? $program->tipo;
            $program->modalidad = $data['modalidad'] ?? $program->modalidad;
            $program->fecha_inicio = $data['fecha_inicio'] ?? $program->fecha_inicio;
            $program->fecha_final = $data['fecha_final'] ?? $program->fecha_final;
            $program->costo = $data['costo'] ?? $program->costo;
            $program->hrs_academicas = $data['hrs_academicas'] ?? $program->hrs_academicas;
            $program->has_grafica = $data['has_grafica'] ?? $program->has_grafica;
            $program->has_editable = $data['has_editable'] ?? $program->has_editable;
            $program->cantidad_modulos = $data['cantidad_modulos'] ?? $program->cantidad_modulos;
            $program->esta_en_oferta = $data['esta_en_oferta'] ?? $program->esta_en_oferta;
            $program->save();
            return $program;
        } catch (\Throwable $th) {
            return false;
        }
    }

    static  public function delete($id)
    {
        try {
            $program = Program::find($id);
            $program->delete();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
};
