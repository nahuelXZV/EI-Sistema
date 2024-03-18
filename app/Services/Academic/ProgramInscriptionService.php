<?php

namespace App\Services\Academic;

use App\Models\ProgramInscription;

class ProgramInscriptionService
{
    public function __construct()
    {
    }

    static public function getAllByStudent($student)
    {
        $inscriptions = ProgramInscription::where('estudiante_id', $student)->get();
        return $inscriptions;
    }

    static public function getAllByProgramPaginate($program)
    {
        $inscriptions = ProgramInscription::join('program', 'program.id', '=', 'program_inscription.programa_id')
            ->join('student', 'student.id', '=', 'program_inscription.estudiante_id')
            ->select('student.* as estudiante')
            ->where('programa_id', $program)->paginate(10);
        return $inscriptions;
    }

    static public function getAllByProgram($program)
    {
        $inscriptions = ProgramInscription::where('programa_id', $program)->get();
        return $inscriptions;
    }

    static public function getAllPaginate($attribute, $paginate, $order = "desc")
    {
        $inscriptions = ProgramInscription::join('program', 'program.id', '=', 'program_inscription.programa_id')
            ->join('student', 'student.id', '=', 'program_inscription.estudiante_id')
            ->select('program_inscription.*', 'program.* as programa', 'student.* as estudiante')
            ->where('program.nombre', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orWhere('program.codigo', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orWhere('student.nombre', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orWhere('student.apellido', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orWhere('student.cedula', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orderBy('program.nombre', $order)
            ->paginate($paginate);
        return $inscriptions;
    }

    static  public function getOne($id)
    {
        $inscription = ProgramInscription::find($id);
        return $inscription;
    }

    static public function getOneByStudentAndProgram($student, $program)
    {
        $inscription = ProgramInscription::where('estudiante_id', $student)->where('programa_id', $program)->first();
        return $inscription ?? false;
    }

    static public function create($data)
    {
        try {
            $new = ProgramInscription::create($data);
            return $new;
        } catch (\Throwable $th) {
            return false;
        }
    }

    static public function update($data)
    {
        try {
            $inscription = ProgramInscription::find($data['id']);
            $inscription->estudiante_id = $data['estudiante_id'] || $inscription->estudiante_id;
            $inscription->programa_id = $data['programa_id'] || $inscription->programa_id;
            $inscription->save();
            return $inscription;
        } catch (\Throwable $th) {
            return false;
        }
    }

    static  public function delete($id)
    {
        try {
            $inscription = ProgramInscription::find($id);
            $inscription->delete();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
};
