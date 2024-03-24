<?php

namespace App\Services\Academic;

use App\Models\ModuleInscription;

class ModuleInscriptionService
{
    public function __construct()
    {
    }

    static public function getAllByStudentAndProgram($student, $program)
    {
        $inscriptions = ModuleInscription::join('module', 'module.id', '=', 'module_inscription.modulo_id')
            ->join('student', 'student.id', '=', 'module_inscription.estudiante_id')
            ->select('module_inscription.*', 'module.* as modulo')
            ->where('estudiante_id', $student)
            ->where('programa_id', $program)
            ->get();
        return $inscriptions;
    }

    static public function getAllByStudent($student)
    {
        $inscriptions = ModuleInscription::where('estudiante_id', $student)->get();
        return $inscriptions;
    }

    static public function getAllByStudentPaginate($student)
    {
        $inscriptions = ModuleInscription::join('module', 'module.id', '=', 'module_inscription.modulo_id')
            ->join('student', 'student.id', '=', 'module_inscription.estudiante_id')
            ->select('module.* as modulo')
            ->where('estudiante_id', $student)->paginate(10);
        return $inscriptions;
    }

    static public function getAllByModulePaginate($module)
    {
        $inscriptions = ModuleInscription::join('module', 'module.id', '=', 'module_inscription.modulo_id')
            ->join('student', 'student.id', '=', 'module_inscription.estudiante_id')
            ->select('student.*', 'module_inscription.nota as nota', 'module_inscription.observacion as observacion')
            ->where('modulo_id', $module)
            ->paginate(10);
        return $inscriptions;
    }

    static public function getAllStudentAndGradeByModule($module)
    {
        $inscriptions = ModuleInscription::join('module', 'module.id', '=', 'module_inscription.modulo_id')
            ->join('student', 'student.id', '=', 'module_inscription.estudiante_id')
            ->select('student.*', 'module_inscription.nota as nota', 'module_inscription.observacion as observacion')
            ->where('modulo_id', $module)
            ->get();
        return $inscriptions;
    }


    static public function getAllByModule($module)
    {
        $inscriptions = ModuleInscription::where('modulo_id', $module)->get();
        return $inscriptions;
    }

    static public function getAllPaginate($attribute, $paginate, $order = "desc")
    {
        $inscriptions = ModuleInscription::join('module', 'module.id', '=', 'module_inscription.modulo_id')
            ->join('student', 'student.id', '=', 'module_inscription.estudiante_id')
            ->select('module_inscription.*', 'module.* as modulo', 'student.* as estudiante')
            ->where('module.nombre', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orWhere('module.codigo', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orWhere('student.nombre', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orWhere('student.apellido', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orWhere('student.cedula', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orderBy('module.nombre', $order)
            ->paginate($paginate);
        return $inscriptions;
    }

    static  public function getOne($id)
    {
        $inscription = ModuleInscription::find($id);
        return $inscription;
    }

    static public function getOneByStudentAndModule($student, $module)
    {
        $inscription = ModuleInscription::where('estudiante_id', $student)->where('modulo_id', $module)->first();
        return $inscription ?? false;
    }

    static public function create($data)
    {
        try {
            $new = ModuleInscription::create($data);
            return $new;
        } catch (\Throwable $th) {
            return false;
        }
    }

    static public function update($data)
    {
        try {
            $inscription = ModuleInscription::find($data['id']);
            $inscription->estudiante_id = $data['estudiante_id'] || $inscription->estudiante_id;
            $inscription->modulo_id = $data['modulo_id'] || $inscription->modulo_id;
            $inscription->save();
            return $inscription;
        } catch (\Throwable $th) {
            return false;
        }
    }

    static public function updateGrade($data)
    {
        try {
            $inscription = ModuleInscription::find($data['id']);
            $inscription->nota = $data['nota'];
            $inscription->observacion = $data['observacion'];
            $inscription->save();
            return $inscription;
        } catch (\Throwable $th) {
            return false;
        }
    }

    static  public function delete($id)
    {
        try {
            $inscription = ModuleInscription::find($id);
            $inscription->delete();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
};
